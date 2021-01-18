<?php


namespace App\Controller;


use App\Exception\ValidationException;
use App\Model\Ads;
use App\Model\User;

class AdsController
{
    private Ads $adsModel;

    public function __construct()
    {
        $this->adsModel = new Ads('ads');
    }

    public function index()
    {
        $ads = $this->adsModel->findAll();

        $data = [
            'title' => 'Ads list',
            'ads' => $ads
        ];
        return view('ads.ads_list', $data);
    }

    public function create(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'Ads registration',
            ];
            return view('ads.ads_create', $data);
        }

        $errors = [];
        $data = $_POST;
        if (empty($data['title'])) {
            $errors['title'] = 'Cannot be empty';
        }

        if (empty($data['body'])) {
            $errors['body'] = 'Cannot be empty';
        }

        if ($errors) {
            throw new ValidationException($errors);
        }

        $this->adsModel->save([
            'title' => $data['title'],
            'body' => $data['body'],
        ]);

        header('Location: /ads');
        exit;


    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $this->adsModel->remove($id);
        }
        header('Location: /ads');
        exit;
    }


}