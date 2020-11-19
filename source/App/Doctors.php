<?php


namespace Source\App;


use Source\Core\Controller;
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
use Source\Models\SubGroup;
use Source\Support\Message;

/**
 * Class Doctors
 * @package Source\App
 */
class Doctors extends Controller
{
    /**
     * Doctors constructor.
     */
    public function __construct()
    {
        parent::__construct(CONF_VIEW_PATH . CONF_VIEW_THEME);
    }

    public function all(array $data): void
    {
        $speciality = (new Speciality())->findBySlug($data['specialitySlug']);

        $doctorSpecialities = (new DoctorSpeciality())->find('speciality_id = :id', "id={$speciality->id}")->fetch(true);

        $doctors = $this->doctors($doctorSpecialities);

        echo $this->view->render('widgets/doctors/home', [
            'doctors' => $doctors
        ]);
    }

    /**
     * @param array|null $data
     */
    public function createSpeciality(?array $data): void
    {
        $speciality = (new Speciality())->findBySlug($data['specialitySlug']);

        if (!empty($data) && $_SERVER['REQUEST_METHOD'] === "POST") {
            if (!csrf_verify($data)) {
                $json['message'] = (new Message())->error("Por favor utilize o formulário para submeter os dados")->render();
                echo json_encode($json);
                return;
            }

            $doctor = new Doctor();
            $doctor->name = $data['name'];

            if (!$doctor->save()) {
                $json['message'] = $doctor->message()->render();
                echo json_encode($json);
                return;
            }

            // Doctors Speciality
            $doctorSpeciality = new DoctorSpeciality();
            $doctorSpeciality->speciality_id = $speciality->id;
            $doctorSpeciality->doctor_id = $doctor->id;

            if (!$doctorSpeciality->save()) {
                $doctor->destroy();
                $json['message'] = $doctorSpeciality->message()->render();
                echo json_encode($json);
                return;
            }

            $this->create($data, $doctor->id);

            (new Message())->success("Cobertura cadastrada com sucesso")->flash();
            $json['redirect'] = url("/especialidades/{$speciality->slug}/atos-medicos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/especialidades/{$speciality->slug}/atos-medicos/cadastrar"),
            ''
        );

        echo $this->view->render('widgets/doctors/add', [
            'speciality' => $speciality->data()
        ]);
    }

    /**
     * @param array|null $data
     */
    public function createRoof(?array $data): void
    {
        $roof = (new Roof())->findBySlug($data['roofSlug']);

        if (!empty($data) && $_SERVER['REQUEST_METHOD'] === "POST") {
            if (!csrf_verify($data)) {
                $json['message'] = (new Message())->error("Por favor utilize o formulário para submeter os dados")->render();
                echo json_encode($json);
                return;
            }

            $doctor = new Doctor();
            $doctor->name = $data['name'];

            if (!$doctor->save()) {
                $json['message'] = $doctor->message()->render();
                echo json_encode($json);
                return;
            }

            // Doctors Speciality
            $doctorRoof = new DoctorRoof();
            $doctorRoof->roof_id = $roof->id;
            $doctorRoof->doctor_id = $doctor->id;

            if (!$doctorRoof->save()) {
                $doctor->destroy();
                $json['message'] = $doctorRoof->message()->render();
                echo json_encode($json);
                return;
            }

            $this->create($data, $doctor->id);

            (new Message())->success("Cobertura cadastrada com sucesso")->flash();
            $json['redirect'] = url("/especialidades/coberturas/{$roof->slug}/atos-medicos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/especialidades/{$roof->slug}/atos-medicos"),
            ''
        );

        echo $this->view->render('widgets/doctors/addRoofing', [
            'roof' => $roof->data()
        ]);
    }

    /**
     * @param array $data
     * @param int $id
     */
    private function create(array $data, int $id): void
    {
        // Doctors Code
        if (!empty($data['code'])) {
            $doctorCode = new DoctorCode();
            $doctorCode->doctor_id = $id;
            $doctorCode->code = $data['code'];

            if (!$doctorCode->save()) {
                $json['message'] = $doctorCode->message()->render();
                echo json_encode($json);
                return;
            }
        }

        // Doctors Value
        if (!empty($data['value'])) {
            $doctorValue = new DoctorValue();
            $doctorValue->doctor_id = $id;
            $doctorValue->content = $data['value'];

            if (!$doctorValue->save()) {
                $json['message'] = $doctorValue->message()->render();
                echo json_encode($json);
                return;
            }
        }

        // Doctors commentary
        if (!empty($data['commentary'])) {
            $commentary = new Commentary();
            $commentary->doctor_id = $id;
            $commentary->content = $data['commentary'];

            if (!$commentary->save()) {
                $json['message'] = $commentary->message()->render();
                echo json_encode($json);
                return;
            }
        }

        // Doctors group
        if (!empty($data['group'])) {
            $group = new Group();
            $group->doctor_id = $id;
            $group->name = $data['group'];

            if (!$group->save()) {
                $json['message'] = $group->message()->render();
                echo json_encode($json);
                return;
            }
        }

        // Doctors sub-group
        if (!empty($data['subgroup'])) {
            $subGroup = new SubGroup();
            $subGroup->doctor_id = $id;
            $subGroup->name = $data['subgroup'];

            if (!$subGroup->save()) {
                $json['message'] = $subGroup->message()->render();
                echo json_encode($json);
                return;
            }
        }
    }

    /**
     * @param array $data
     */
    public function allRoof(array $data): void
    {
        $roof = (new Roof())->findBySlug($data['roofSlug']);

        $doctorsRoofing = (new DoctorRoof())->find('roof_id = :id', "id={$roof->id}")->fetch(true);

        $doctors = $this->doctors($doctorsRoofing);

        echo $this->view->render('widgets/doctors/homeRoofing', [
            'doctors' => $doctors
        ]);
    }

    private function doctors(array $docs): array
    {
        $doctors = [];
        foreach ($docs as $doc) {
            $obj = new \stdClass();

            $doctor = (new Doctor())->findById($doc->doctor_id);

            $obj->name = $doctor->name;

            $doctorCode = (new DoctorCode())->findByDoctorId($doctor->id);
            $obj->code = $doctorCode->code ?? "null";

            $doctorValue = (new DoctorValue())->findByDoctorId($doctor->id);
            $obj->value = $doctorValue->content ?? "null";

            $commentary = (new Commentary())->findByDoctorId($doctor->id);
            $obj->commentary = $commentary->content ?? "null";

            $group = (new Group())->findByDoctorId($doctor->id);
            $obj->group = $group->name ?? "null";

            $subGroup = (new SubGroup())->findByDoctorId($doctor->id);
            $obj->subgroup = $subGroup->name ?? "null";

            $doctors[] = $obj;
        }

        return $doctors;
    }
}