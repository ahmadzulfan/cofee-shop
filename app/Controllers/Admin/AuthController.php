<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('admin')->with('success', 'Anda sudah login!');
        }
        $data['title'] = 'Login';
        return view('admin/auth/login.php', $data);
    }

    public function doLogin()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('admin')->with('success', 'Anda sudah login!');
        }
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            $session->set([
                'user_id'  => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'logged_in' => true
            ]);
            return redirect()->to('admin')->with('success', 'Selamat datang ' . $user->name);
        } else {
            return redirect()->to('admin/auth/login')->with('error', 'Email atau password salah!');
        }
    }

    public function logout()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('admin/auth/login')->with('error', 'Anda belum login!');
        }
        session()->destroy();
        return redirect()->to('admin/auth/login')->with('success', 'Anda sudah logout!');
    }

    public function myAccount()
    {
        $id = session()->get('user_id');
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/auth/login')->with('error', 'User tidak ditemukan!');
        }
        
        $data['user'] = $user;

        return view('admin/my_account.php', $data);
    }

    public function changePassword()
    {
        $userId = session()->get('user_id'); // asumsi ID user tersimpan di session
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!password_verify($oldPassword, $user->password)) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

}
