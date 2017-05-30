<?php

namespace Yeticave\Core;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

abstract class Controller
{

    protected $route_params = [];

    public function __construct(array $route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                $result = call_user_func_array([$this, $method], $args);
                $this->after();
                return $result;
            }
        } else {
            echo "Method $method not found in controller" . get_class($this);
        }
    }

    protected function before()
    {

    }

    protected function after()
    {

    }

    public function validateFormFields(array &$fields,bool &$form_validated)
    {
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $fields)) {
                try {
                    /**
                     * @var Validator $var
                     */
                    $fields[$key]['value'] = trim($value);
                    $var = $fields[$key]['v'];
                    $var->assert($fields[$key]['value']);
                } catch (NestedValidationException $e) {
                    $form_validated = false;
                    $fields[$key]['errors'] = $e->getMessages();
                }
            }
        }
    }

    public function validatePhotoUpload(array &$file, bool &$form_validated, bool $isNecessary)
    {
        if (isset($_FILES['photo']) && !$_FILES['photo']['error']) {
            if (in_array($_FILES['photo']['type'],['image/jpeg','image/png'])) {
                $file['name'] = basename($_FILES['photo']['name']);
                $file['path'] = $_SERVER["DOCUMENT_ROOT"] . '\public\uploads\\' . $file['name'];
                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $file['path'])) {
                    $file['error'] = 'Ошибка при загрузке картинки';
                    $form_validated = false;
                }
            } else {
                $file['error'] = 'Картинка должна быть в формате jpeg или png';
                $form_validated = false;
            }
        } elseif ($isNecessary) {
            $file['error'] = 'Картинка должна быть загружена';
            $form_validated = false;
        }
    }

    protected function render(string $view, $params = [])
    {
        return View::render($view, $params);
    }
}
