<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use App\Models\User;
use App\Models\UserDiscord;

class OauthController extends Controller
{
    /**
     * 重新導向 discord API
     */
    public function discordAuth(Request $request)
    {
        if (Auth::viaRemember()) {

        }

        return Socialite::driver('discord')
            ->scopes(['guilds', 'guilds.members.read'])
            ->redirect();
    }

    /**
     * 取得 discord 登入API 回應
     */
    public function discordCallback(Request $request)
    {
        $discordUser = Socialite::driver('discord')->user();

        # 建立 UserDiscord 模型
        $model = UserDiscord::where('socialite', 'discord')->where('uid', $discordUser->id)->first();
        if (!$model) {
            $model = new UserDiscord();
        }
        $model->socialite = 'discord';
        $model->uid = $discordUser->id;
        $model->name = $discordUser->nickname;
        $model->email = $discordUser->email;
        $model->avatar = $discordUser->avatar;
        $model->token = $discordUser->token;
        $model->expires = date('Y-m-d H:i:s', time() + $discordUser->expiresIn);

        $model->save();

        # 建立 User 模型
        $userModel = User::where('id', $model->id)->first();
        if (!$userModel) {
            $userModel = new User();
        }

        $userModel->name = $model->name;
        $userModel->email = $model->email;

        $userModel->save();

        // 手動通過驗證
        Auth::login($userModel, $remember = true);

        // dd(Auth::check());

        // dd($model->listGuilds());
        // dd($model->getGuildInfo(846043221665513472));
    }
}
