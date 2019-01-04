<?php

namespace App\Http\Controllers\Api\H;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Validator;
use App\User;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // 获取路由前缀
        // var_dump($request->route()->action['prefix']);die;
        // bcrypt
        // 验证
        $register = $request->only('name', 'password');
        $validator = Validator::make($register, [
            'name' => 'Min:3|String|Required|Unique:users',
            'password' => 'Min:6|String|Required'
        ],[
            'name.required' => '用户名必填',
            'name.unique' => '用户名已存在',
            'name.min' => '用户名不能小于3位',
            'password.required' => '密码必填',
            'password.min' => '密码不能小于6位',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ]);
        }
        // 加密密码
        $register['password'] = bcrypt($register['password']);
        // 入库
        $user = User::create($register);
        if($user){
            // 生成token
            $token = JWTAuth::attempt($request->only('name', 'password'));
            if(!$token){
                return response()->json([
                    'code' => 1,
                    'message' => '生成失败',
                    'data' => []
                ]);
            }
        }

        return response()->json([
            'code' => 0,
            'message' => '注册成功',
            'data' => compact('token')
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
