<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\FeedbacksModel;
use Config\Services;

class UserController extends BaseController
{
    protected $categoriesModel;
    protected $productsModel;

    public function __construct()
    {
        $this->categoriesModel = new CategoriesModel();
        $this->productsModel = new ProductsModel();
    }

    public function profile(){
        return view('user/indexProfile');
    }

    public function editProfile(){
        return view('user/indexProfileEdit');
    }

    public function sendFeedback()
    {
        // Validasi input
        $validation = Services::validation();
        $validation->setRules([
            'username' => 'required|max_length[30]',
            'email' => 'required|valid_email|max_length[255]',
            'message' => 'required|max_length[500]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Redirect kembali dengan error jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $data = [
            'user_id'    => user()->__get('id'), // Ambil user ID dari session/authentication
            'username'   => $this->request->getPost('username'),
            'email'      => user()->__get('email'), // Email dari session/authentication
            'message'    => $this->request->getPost('message'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan ke database
        $feedbackModel = new FeedbacksModel();
        if ($feedbackModel->insert((object) $data)) {
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
        } else {
            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim feedback.');
        }
    }

    public function sendNewProfile()
    {
        $userId = user()->id;
        $currentUsername = user()->username;
        $newUsername = $this->request->getPost('username');
        $currentEmail = user()->email;  // ambil email saat ini dari user yang login
        $newEmail = $this->request->getPost('email');  // email dari form

        // Siapkan data untuk update
        $data = [
            'birthdate' => $this->request->getPost('birthdate'),
            'address' => $this->request->getPost('address'),
            'phone_number' => $this->request->getPost('phone_number')
        ];

        // Cek apakah username berubah
        if ($newUsername !== $currentUsername) {
            $data['username'] = $newUsername;
        }

        // Cek apakah email berubah
        if ($newEmail !== $currentEmail) {
            // Jika email berubah, tambahkan ke data update
            $data['email'] = $newEmail;
        }

        // Validasi input
        $validationRules = [
            'birthdate' => 'permit_empty|valid_date',
            'address' => 'permit_empty|max_length[500]',
            'phone_number' => 'permit_empty|numeric',
            'profile_picture' => 'permit_empty|uploaded[profile_picture]|max_size[profile_picture,2048]|is_image[profile_picture]|mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
        ];

        // Tambahkan validasi username hanya jika username berubah
        if ($newUsername !== $currentUsername) {
            // Perbaikan pada interpolasi string untuk $userId
            $validationRules['username'] = "required|max_length[255]|is_unique[users.username,id,$userId]";
        }

        // Tambahkan validasi email hanya jika email berubah
        if ($newEmail !== $currentEmail) {
            $validationRules['email'] = "required|valid_email|max_length[255]|is_unique[users.email,id,$userId]";
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload jika ada
        $profilePicture = $this->request->getFile('profile_picture');
        $uploadPath = ROOTPATH . 'public/uploads/profile_pictures';
        if ($profilePicture && $profilePicture->isValid()) {
            $newFilename = $profilePicture->getRandomName();
            if ($profilePicture->move($uploadPath, $newFilename)) {
                $data['profile_picture'] = 'uploads/profile_pictures/' . $newFilename;
            }
        }

        // Update database
        $userModel = new UserModel();
        try {
            $updated = $userModel->update($userId, $data);
            
            if ($updated) {
                return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
            } else {
                log_message('error', 'Update gagal. Error: ' . print_r($userModel->errors(), true));
                return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception saat update: ' . $e->getMessage());
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }
}
