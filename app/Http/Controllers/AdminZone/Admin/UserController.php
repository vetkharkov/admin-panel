<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Requests\AdminUserEditRequest;
use App\Models\Admin\User;
use App\Models\UserRole;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\UserRepository;
use MetaTag;

class UserController extends AdminBaseController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
//        $this->userRepository = app(UserRepository::class);
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage =10;
        $countUsers = MainRepository::getCountUsers();
        $paginator = $this->userRepository->getAllUsers($perPage);


        MetaTag::setTags(['title' => "Список пользователей"]);

        return view('admin-panel.admin.user.index', compact('countUsers', 'paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        MetaTag::setTags(['title' => "Добавление пользователя"]);

        return view('admin-panel.admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserEditRequest $request)
    {
        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => $request['password'],
        ]);

        if (!$user)
        {
            return back()->withErrors(['Ошибка создания пользователя'])->withInput();
        } else {
            $role = UserRole::create([
               'user_id' => $user->id,
               'role_id' => (int)$request['role']
            ]);
            if (!$role)
            {
                return back()->withErrors(['Ошибка создания роли пользователя'])->withInput();
            } else {
                return redirect()
                    ->route('adminzone.admin.users.index')
                    ->with(['success' => 'Пользователь успешно сохранён']);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perPage = 10;

        $item =$this->userRepository->getId($id);
        if (empty($item)) {
            abort('404');
        }

        $orders = $this->userRepository->getUserOrders($id, $perPage);

        $role = $this->userRepository->getUserRole($id);

        $count = $this->userRepository->getCountOrdersPag($id);

        $count_orders = $this->userRepository->getCountOrders($id, $perPage);

        MetaTag::setTags(['title' => "Редактирование пользователя № {$item->id}"]);

        return view('admin-panel.admin.user.edit',compact('item', 'orders', 'role', 'count', 'count_orders'));
    }

    /**
     * @param AdminUserEditRequest $request
     * @param User $user
     * @param UserRole $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminUserEditRequest $request, User $user, UserRole $role)
    {
        $user->name = $request['name'];
        $user->email = $request['email'];
        $request['password'] == null ?: $user->password = bcrypt($request['password']);
        $save = $user->save();

        if (!$save)
        {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])->withInput();
        } else {
            $role->where('user_id', $user->id)->update(['role_id' => (int)$request['role']]);

            return redirect()
                    ->route('adminzone.admin.users.edit', $user->id)
                    ->with(['success' => 'Успешно сохранено']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->forceDelete();
        if ($result) {
            return redirect()
                ->route('adminzone.admin.users.index')
                ->with(['success' => 'Пользователь '. ucfirst($user->name) .' удалён']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
