<?php

namespace App\Repositories\Users;

use App\Models\{Log, User};
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Hash,Auth};
use Illuminate\Http\{Request};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository extends Repository
{
    public function __construct(User $model, array $relations = [])
    {
        parent::__construct($model, $relations);
    }

    /**
     * Metodo para registrar un nuevo customer.
     *
     * @param Request $data
     */
    public function register(Request $data) {
        $customer = $this->model->create([
            'name' => $data->name,
            'last_name' => $data->last_name,
            'dni' => $data->dni,
            'email' => $data->email,
            'address' => isset($data->address) ? $data->address : null,
            'password' => Hash::make($data->password),
            'email_verified_at' => Carbon::now(),
            'date_reg' => Carbon::now()->format('d/m/Y H:i'),
            'id_com' => $data->id_com,
            'id_reg' => $data->id_reg,
        ]);

        Log::create([
            'user_id' => $customer->id,
            'action' => 'Register',
            'description' => 'Registro de nuevo customer.',
            'ip' => request()->getClientIp(),
        ]);

        return $customer;
    }

    /**
     * Metodo para buscar un customer.
     *
     * @param string $search
     */
    public function search(string $search) {
        try {
            $customer = $this->model->search($search)->firstOrFail();

            $varENV = config('app.env');
    
            if ($varENV === 'local') {
                Log::create([
                    'user_id' => $customer->id,
                    'action' => 'Search',
                    'description' => 'Búsqueda del customer ' . $search . '.',
                    'ip' => request()->getClientIp(),
                ]);
            }

            return $customer;
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    /**
     * Metodo para eliminar lógicamente un customer.
     *
     * @param string $search
     * @return bool
     */
    public function eliminarUser(string $search, Request $request) : bool {
        $band = false;
        $customer = $this->search($search);

        if (isset($customer)) {
            if ($customer->id != Auth::user()->id) {
                $customer->update([
                    'status' => 'trash'
                ]);

                $varENV = config('app.env');

                if ($varENV === 'local') {
                    Log::create([
                        'user_id' => $customer->id,
                        'action' => 'Delete',
                        'description' => 'Eliminación de customer ' . $search . '.',
                        'ip' => request()->getClientIp(),
                    ]);
                }

                $band = true;
            }
        }
        return $band;
    }

    public function paginate($relations = null, $paginate = 20, $filtersColumns = []) {
        return (!empty($relations))
            ? $this->model::with($relations)->orderBy('id', 'desc')->paginate($paginate)
            : $this->model::orderBy('id', 'desc')->paginate($paginate);
    }
}
