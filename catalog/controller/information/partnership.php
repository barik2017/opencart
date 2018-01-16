<?php

/**
 * Контроллер для формирования страницы "Партнерство"
 *
 * Class ControllerInformationPartnership
 */
class ControllerInformationPartnership extends Controller {

    /**
     * Метод для вывода страницы "Партнерство"
     */
    public function index()
    {

        /**
         * Подключаем к данном контроллеру файл language
         */
        $this->load->language('information/partnership');

        /**
         * Формируем массив бредкрамбов (хлебных крошек)
         */
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/partnership')
        );

        /**
         * Переменная heading_title - заголовок данной страницы, берем из файла language
         */
        $data['heading_title'] = $this->language->get('heading_title');

        /**
         * Переменная для определения - выводить форму или
         * сообщение об успешной отправке формы
         */
        $data['success'] = false;

         /** Сделаем проверку,
          * обрабатывается ли заявка
          */

        if (isset($this->request->cookie['name']))
        {


            $data['success'] = $this->language->get('text_success');

        }

        /**
         * Если метод HTTP запроса POST, то
         * выполняем валидацию и сохранение данных из формы
         */
        elseif($this->request->server['REQUEST_METHOD'] == 'POST') {

            /*
            $mail = new Mail($this->config->get('config_mail_engine'));
           $mail->parameter = $this->config->get('config_mail_parameter');
             $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');


            $mail->setFrom($this->config->get('config_email'));
            $mail->setTo($this->config->get('config_email'));
            $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
            $mail->setText($this->request->post['comment']);
            $mail->send();
            */

           // $this->response->redirect($this->url->link('information/contact/success'));


            /**
             * Если массив files не пуст, то
             * начинаем обработку загружаемого файла
             */
            if (!empty($this->request->files)) {

                /**
                 * Массив допустимых MIME-типов, которые могут содержать загружаемые файлы
                 */
                $allowed_mime_types = array(
                    'application/excel' => 'application/excel',
                    'application/vndms-excel' => 'application/vndms-excel',
                    'application/x-excel' => 'application/x-excel',
                    'application/x-msexcel' => 'application/x-msexcel',
                    'application/vnd.ms-excel' => 'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vndopenxmlformats-officedocumentspreadsheetmlsheet' => 'application/vndopenxmlformats-officedocumentspreadsheetmlsheet ',
                    'application/pdf' => 'application/pdf',
                     'application/msword' => 'application/msword',
                    'application/vnd.ms-word'=>'application/vnd.ms-word',
                    'application/vndopenxmlformats-officedocumentwordprocessingmldocument'=>'application/vndopenxmlformats-officedocumentwordprocessingmldocument'

                );

/*
                /**
                 * Mime тип загружаемого изображения с формы
                 */
                $our_mime_type = $this->request->files['file']['type'];

                /**
                 * Если mime типа загружаемого файла нет среди ключей массива
                 * $allow_mime_types, значит будем выводить ошибку о типе загружаемого файла;
                 */
                if (!isset($allowed_mime_types[$our_mime_type])) {
                    $data['error']['file'] = $this->language->get('error_file_type');
                }
            }

            if (!empty($this->request->file['file1'])) {

                /**
                 * Массив допустимых MIME-типов, которые могут содержать загружаемые изображения
                 */
                $allowed_mime_types = array(
                    'image/jpeg' => 'image/jpeg',
                    'image/pjpeg' => 'image/pjpeg',
                    'image/png' => 'image/png',
                    'image/x-png' => 'image/x-png'

                );


                /**
                 * Mime тип загружаемого файла с формы
                 */
                $our_mime_type1 = $this->request->files['file1']['type'];


                /**
                 * Если mime типа загружаемого файла нет среди ключей массива
                 * $allow_mime_types, значит будем выводить ошибку о типе загружаемого файла;
                 */
                if (!isset($allowed_mime_types[$our_mime_type1])) {
                    $data['error']['file1'] = $this->language->get('error_file1_type');
                }
            }

           $size_file =  filesize($this->request->files['file1']['tmp_name']);

            if( $size_file > 1000000){
                $data['error']['file'] = $this->language->get('error_file_type');}

            /**
             * Подключем модель к контроллеру
             */
            $this->load->model('catalog/partnership');

            /**
             * Валидация поля email
             */
            if (!$this->request->post['email']) {
                $data['error']['email'] = $this->language->get('error_email');
            }


            /**
             * Валидация поля name
             */
            if (strlen($this->request->post['name']) < 2) {
                $data['error']['name'] = $this->language->get('error_name');

            }

            $name = $this->request->post['name'];





            if (preg_match('/\\d/', ($this->request->post['name'])) == true) {
                $data['error']['name'] = $this->language->get('error_name');
            }

            $array_file = explode(".",$this->request->files['file']['name'] );
            $last_el_mas = array_pop($array_file);
            $time = date('d_m_Y_G_i_s');
            $new_name_file= $time . '_' .$name .'.' . $last_el_mas;
            $this->request->files['file']['name'] = $new_name_file;








            /**
             * Валидация поля tax_form
             */
            if (!$this->request->post['company']) {
                $data['error']['company'] = $this->language->get('error_company');
            }
            /**
             * Валидация поля tax_form
             */
            if (!$this->request->post['tax_form']) {
                $data['error']['tax_form'] = $this->language->get('error_tax_form');
            }
            if (!$this->request->post['age']) {
                $data['error']['age'] = $this->language->get('error_age');
            }
            /**
             * Если массив $data['error'] пуст (это значит, что нет ошибок в форме),
             * то вызываем метод модели addPartner и передаем туда массив с данными из формы
             * для сохранения этих данных в БД
             */
            if (empty($data['error'])) {
                /**
                 * Если есть загруженный файл, делаем перемещение этого файла из папки tmp
                 * туда куда нам нужно
                 */
                if (isset($this->request->files['file']['tmp_name'])) {


                    /**
                     * Темповый путь файла
                     */
                 $tmp_file = $this->request->files['file']['tmp_name'];

                    /**
                     * Путь куда мы сохраняем файл
                     * Используем константу DIR_DOWNLOAD (которая у нас назначается в сonfig.php)
                     */
                    $destination = DIR_DOWNLOAD . $this->request->files['file']['name'];
                    /**
                     * С помощью функции move_uploaded_file делаем перемещение
                     */
                    move_uploaded_file($tmp_file, $destination);
                    /**
                     * Записываем путь хранения нашего файла в массив post,
                     * чтобы в модели в методе addPartner сохранить это значение в базе данных (поле file)
                     */
                   $this->request->post['file'] = $destination;
                }
                $this->request->post['file1'] = file_get_contents($this->request->files['file1']['tmp_name']);

                  


                ($this->model_catalog_partnership->addPartner($this->request->post));


                $data['success'] = $this->language->get('text_success');
            }
        }

        /**
         * Формируем ссылку на этот же контроллер; передаем в атрибут action в форме во view
         */
        $data['action'] = $this->url->link('information/partnership');

        /**
         * Лейблы полей и кнопок формы
         */
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_tax_form'] = $this->language->get('entry_tax_form');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['entry_age'] = $this->language->get('entry_age');
        $data['entry_file'] = $this->language->get('entry_file');
        $data['entry_file1'] = $this->language->get('entry_file1');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['button_send'] = $this->language->get('button_send');
        /**
         * Проверяем есть ли в массиве post значения полей, если да,
         * то присваим их в переменные,
         * а эти переменные выводим во view в элементах формы
         */
        /*if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } else {
            $data['name'] = '';
        }*/


        if (isset($this->request->post['name'])) {
                $data['name'] = $this->request->post['name'];
                //setcookie('name', $data['name'] ,time()+3600);
        }
        else{
                $data['name'] = '';
            }
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = '';
        }
        if (isset($this->request->post['company'])) {
            $data['company'] = $this->request->post['company'];
        } else {
            $data['company'] = '';
        }
        if (isset($this->request->post['tax_form'])) {
            $data['tax_form'] = $this->request->post['tax_form'];
        } else {
            $data['tax_form'] = '';
        }

        if (isset($this->request->post['age'])) {
            if ('age' >= 18) {
                $data['age'] = $this->request->post['age'];
            } else {
                $data['age'] = '';
            }
        } else {
            $data['age'] = '';
        }
        if (isset($this->request->post['comment'])) {
            $data['comment'] = $this->request->post['comment'];
        } else {
            $data['comment'] = '';
        }

        //setcookie('name', $this->request->post['name'] ,time()+3600);

        /**
         * Текст о партнерстве из настроек
         */
        $data['partnership_text'] = $this->config->get('config_partnership_text');

        /**
         * Перечень доступных форм налогообложения из админки
         */
        $data['partnership_tax'] = explode(',', $this->config->get('config_partnership_tax'));

        /**
         * Подключаем футер
         */
        $data['footer'] = $this->load->controller('common/footer');

        /**
         * Подключаем хедер
         */
        $data['header'] = $this->load->controller('common/header');

        /**
         * Формируем ответ браузеру
         * вызываем метод setOutput объекта Response
         * и передаем в него сформированный шаблон
         */



            $this->response->setOutput($this->load->view('information/partnership', $data));


    }
}