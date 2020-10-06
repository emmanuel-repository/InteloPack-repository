<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Auth;
use Illuminate\Http\Request;

class LoginEmpleadoController extends Controller {

    public function __construct() {
        $this->middleware('guest:empleado', ['except' => ['logout']]);
    }

    public function index() {
        return view('login_empleado');
    }

    public function login(Request $request) {
        $data = array();
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        $auth = Auth::guard('empleado')->attempt([
            'email'    => $request->email,
            'password' => $request->password], $request->remember
        );
        if ($auth) {
            $empleado        = new Empleado;
            $select_empleado = $empleado->select_login($request->email);
            if ($select_empleado->estatus_empleado == 1) {
                return redirect()->intended(route('bienvenida.index'));
            } else {
                Auth::guard('empleado')->logout();
                // return redirect()->back()->withInput($request->only('email', 'remember'));
                return redirect()->back()->withErrors(['Este usuario no tiene acceso a 
                    la aplicación ya que se encuentra desactivado']);
            }
        } else {
            // return redirect()->back()->withInput($request->only('email', 'remember'));
            return redirect()->back()->withErrors(['Usuario y/o contraseña es incorrecta']);
        }
    }

    public function logout() {
        Auth::guard('empleado')->logout();
        return redirect()
            ->route('login_empleados')
            ->with('status', 'Admin has been logged out!');
    }
}
