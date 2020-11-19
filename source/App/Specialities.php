<?php


namespace Source\App;


use Source\Models\Comment;
use Source\Models\Commentary;
use Source\Models\Doctor;
use Source\Models\DoctorCode;
use Source\Models\DoctorRoof;
use Source\Models\DoctorSpeciality;
use Source\Models\DoctorValue;
use Source\Models\Group;
use Source\Models\Roof;
use Source\Models\RoofNumber;
use Source\Models\Speciality;
use Source\Models\SpecialityNumber;
use Source\Models\SubGroup;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Specialities
 * @package Source\App
 */
class Specialities extends \Source\Core\Controller
{
    /**
     * Specialities constructor.
     */
    public function __construct()
    {
        parent::__construct(CONF_VIEW_PATH . CONF_VIEW_THEME);
    }

    public function index(array $data): void
    {
        $speciality = (new Speciality())->findBySlug($data['slug']);

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url('/'),
            ''
        );

        echo $this->view->render('widgets/specialities/index', [
            'speciality' => $speciality->data()
        ]);
    }

    public function home()
    {
        $specialities = (new Speciality())->find()->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url('/'),
            ''
        );

        echo $this->view->render('widgets/specialities/home', [
            'specialities' => $specialities ?? []
        ]);
    }

    /**
     * @param array|null $data
     */
    public function register(?array $data): void
    {
        if (!empty($data)) {
            if (!csrf_verify($data)) {
                $json['message'] = (new Message())->error("Por favor utilize o formulário para submeter os dados")->render();
                echo json_encode($json);
                return;
            }

            $speciality = new Speciality();
            $speciality->name = $data['name'];
            $speciality->slug = str_slug($speciality->name);

            if (!$speciality->save()) {
                $json['message'] = $speciality->message()->render();
                echo json_encode($json);
                return;
            }

            // Speciality Numbers
            if (!empty($data['number'])) {
                $specialityNumber = new SpecialityNumber();
                $specialityNumber->speciality_id = $speciality->id;
                $specialityNumber->number = $data['number'];

                if (!$specialityNumber->save()) {
                    $speciality->destroy();
                    $json['message'] = $specialityNumber->message()->render();
                    echo json_encode($json);
                    return;
                }
            }

            // Comment
            if (!empty($data['observation'])) {
                $comment = new Comment();
                $comment->speciality_id = $speciality->id;
                $comment->name = $data['observation'];

                if (!$comment->save()) {
                    $speciality->destroy();
                    $json['message'] = $comment->message()->render();
                    echo json_encode($json);
                    return;
                }
            }

            (new Message())->success("Especialidade criada com sucesso")->flash();
            $json['redirect'] = url('/especialidades');
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url('/'),
            ''
        );

        echo $this->view->render('widgets/specialities/register', []);
    }

    public function test(array $data)
    {
        $speciality = (new Speciality())->findById($data['id']);

        if ($speciality) {
            $number = (new SpecialityNumber())->find('speciality_id = :id', "id={$speciality->id}")->fetch();
            $comment = (new Comment())->find('speciality_id = :id', "id={$speciality->id}")->fetch();

            $object = new \stdClass();

            $object->especialidade = $speciality->name;
            $object->observacao = $comment->name ?? null;
            $object->number = $number->number ?? null;

            // Verificar se existe cobertura nessa especialidade
            $roofing = (new Roof())->find('speciality_id = :id', "id={$speciality->id}")->fetch(true);
            if ($roofing) {
                $object->cobertura = [];
                foreach ($roofing as $item) {
                    $roof = new \stdClass();
                    $roof->name = $item->name;

                    $roofNumber = (new RoofNumber())->find('roof_id = :id', "id={$item->id}")->fetch();

                    $roof->number = $roofNumber ? $roofNumber->number : null;

                    // Verificar se nesta cobertura existe atos médicos
                    $doctorRoofing = (new DoctorRoof())->find('roof_id = :id', "id={$item->id}")->fetch(true);
                    if ($doctorRoofing) {
                        $roof->doctors = [];
                        foreach ($doctorRoofing as $doctorRoof) {

                            $doctorModel = (new Doctor())->findById($doctorRoof->doctor_id);

                            $doctor = new \stdClass();

                            $doctor->name = $doctorModel->name;

                            // Get code
                            $doctorCode = (new DoctorCode())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                            $doctor->code = $doctorCode ? $doctorCode->code : null;

                            // Get value
                            $doctorValue = (new DoctorValue())->find('doctor_id = :id',
                                "id={$doctorRoof->id}")->fetch();
                            $doctor->value = $doctorValue ? $doctorValue->content : null;

                            // Get commentary
                            $commentary = (new Commentary())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                            $doctor->commentary = $commentary ? $commentary->content : null;

                            // Get group
                            $group = (new Group())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                            $doctor->group = $group ? $group->name : null;

                            // Get sub-group
                            $subgroup = (new SubGroup())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                            $doctor->subgroup = $subgroup ? $subgroup->name : null;

                            array_push($roof->doctors, $doctor);
                        }
                    }

                    array_push($object->cobertura, $roof);
                }
            }

            // Verificar se a especialidade também contém atos médicos
            $doctorSpecialities = (new DoctorSpeciality())->find('speciality_id = :id', "id={$speciality->id}")->fetch(true);
            if ($doctorSpecialities) {
                $object->doctors = [];
                foreach ($doctorSpecialities as $doctorSpeciality) {
                    $doctor = new \stdClass();

                    $doctorModel = (new Doctor())->findById($doctorSpeciality->doctor_id);

                    $doctor->name = $doctorModel->name;

                    // Get code
                    $doctorCode = (new DoctorCode())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                    $doctor->code = $doctorCode ? $doctorCode->code : null;

                    // Get value
                    $doctorValue = (new DoctorValue())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                    $doctor->value = $doctorValue ? $doctorValue->content : null;

                    // Get commentary
                    $commentary = (new Commentary())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                    $doctor->commentary = $commentary ? $commentary->content : null;

                    // Get group
                    $group = (new Group())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                    $doctor->group = $group ? $group->name : null;

                    // Get sub-group
                    $subgroup = (new SubGroup())->find('doctor_id = :id', "id={$doctorModel->id}")->fetch();
                    $doctor->subgroup = $subgroup ? $subgroup->name : null;

                    array_push($object->doctors, $doctor);
                }
            }

            echo json_encode([$object], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

//            $fopen = fopen(__DIR__ . "/test.json", 'w');
//
//            fwrite($fopen, $json);

        } else {
            echo json_encode([
                'message' => "Nenhuma especialidade encontrada"
            ]);
        }
    }
}