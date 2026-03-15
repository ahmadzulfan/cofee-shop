<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/user/index', $data);
    }

    public function create()
    {
        return view('admin/user/form');
    }

    public function store()
    {
        $rules = [
            'name'     => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'phone'    => [
                'label' => 'Nomor HP',
                'rules' => 'required|numeric|min_length[10]|max_length[13]|regex_match[/^08[0-9]+$/]|is_unique[users.phone]'
            ],
            'address'  => 'permit_empty',
            'role'     => 'required|in_list[admin,dapur,pemilik]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $saveData = [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'address'    => $data['address'],
            'role'       => $data['role'],
            'password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->userModel->save($saveData);

        return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengguna tidak ditemukan.");
        }

        return view('admin/user/form', ['user' => $user]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengguna tidak ditemukan.");
        }

        $rules = [
            'name'    => 'required',
            'email'   => "required|valid_email|is_unique[users.email,id,{$id}]",
            'phone'   => [
                'label' => 'Nomor HP',
                'rules' => 'required|numeric|min_length[10]|max_length[13]|regex_match[/^08[0-9]+$/]|is_unique[users.phone,id,'.$id.']'
            ],
            'address' => 'permit_empty',
            'role'    => 'required|in_list[admin,kitchen,owner]',
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $updateData = [
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'],
            'address' => $data['address'],
            'role'    => $data['role'],
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to(base_url('admin/users'))->with('success', 'Pengguna berhasil dihapus.');
    }
}
