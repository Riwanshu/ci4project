<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login'); // Shows the login form (login.php)
    }

    public function auth()
    {
        $username    = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first(); // ✅ Query builder (safe)


        // Vulnerable query (testing purpose only)
        // $sql = "SELECT * FROM users WHERE username = " . $username . " LIMIT 1";
        // $query = $db->query($sql);
        // $user = $query->getRowArray();

        if ($user) {
            // ✅ Direct compare, because DB password is plain
            if ($password === $user['password']) {
                session()->set([
                    'user_id'     => $user['id'],
                    'username'       => $user['username'],
                    'isLoggedIn'  => true
                ]);
                return redirect()->to('/?id=' . $user['id']); // 👈 user ID add in URL
            } else {
                return redirect()->back()->with('error', 'Incorrect password');
            }
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login')); // ✅ Redirect to login
    }
}
