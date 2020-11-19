<?php


namespace Source\App;


use Source\Core\Controller;
use Source\Models\DoctorRoof;
use Source\Models\Roof;
use Source\Models\RoofNumber;
use Source\Models\Speciality;
use Source\Support\Message;

class Roofing extends Controller
{
    public function __construct()
    {
        parent::__construct(CONF_VIEW_PATH . CONF_VIEW_THEME);
    }

    public function index(?array $data)
    {
        $roof = (new Roof())->findBySlug($data['roofSlug']);

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/especialidades/{ssss}/coberturas/cadastrar"),
            ''
        );

        echo $this->view->render('widgets/roofing/index', [
            'roof' => $roof
        ]);
    }

    public function all()
    {
        $roofingModel = (new Roof())->find()->fetch(true);

        $roofing = [];
        if ($roofingModel) {
            foreach ($roofingModel as $roof) {
                $roofNumber = (new RoofNumber())->find('roof_id = :id', "id={$roof->id}")->fetch();
                $count = (new DoctorRoof())->find('roof_id = :id', "id={$roof->id}")->count();

                $roof->number = $roofNumber ? $roofNumber->number : "null";
                $roof->count = $count;

                $roofing[] = $roof->data();
            }
        }

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/especialidades/{ssss}/coberturas/cadastrar"),
            ''
        );

        echo $this->view->render('widgets/roofing/home', [
            'roofing' => $roofing
        ]);
    }

    public function create(?array $data): void
    {

        $speciality = (new Speciality())->findBySlug($data['specialitySlug']);

        if (!empty($data) && $_SERVER['REQUEST_METHOD'] === "POST") {
            if (!csrf_verify($data)) {
                $json['message'] = (new Message())->error("Por favor utilize o formulário para submeter os dados")->render();
                echo json_encode($json);
                return;
            }

            $roof = new Roof();
            $roof->speciality_id = $speciality->id;
            $roof->name = $data['name'];
            $roof->slug = str_slug($roof->name);

            if (!$roof->save()) {
                $json['message'] = $roof->message()->render();
                echo json_encode($json);
                return;
            }

            // Speciality Numbers
            if (!empty($data['number'])) {
                $roofNumber = new RoofNumber();
                $roofNumber->roof_id = $roof->id;
                $roofNumber->number = $data['number'];

                if (!$roofNumber->save()) {
                    $roofNumber->destroy();
                    $json['message'] = $roofNumber->message()->render();
                    echo json_encode($json);
                    return;
                }
            }

            (new Message())->success("Cobertura cadastrada com sucesso")->flash();
            $json['redirect'] = url("/especialidades/{$speciality->slug}/coberturas");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/especialidades/{$speciality->slug}/coberturas/cadastrar"),
            ''
        );

        echo $this->view->render('widgets/roofing/add', [
            'speciality' => $speciality->data()
        ]);
    }
}