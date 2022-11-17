<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\UserDiscord;

class OauthController extends Controller
{
    /**
     * 重新導向 discord API
     */
    public function discordAuth(Request $request)
    {
        return Socialite::driver('discord')
            ->scopes(['guilds', 'guilds.members.read'])
            ->redirect();
    }

    /**
     * 取得 discord 登入API 回應
     */
    public function discordCallback()
    {
        $discordUser = Socialite::driver('discord')->user();

        $model = new UserDiscord();
        $model->socialite = 'discord';
        $model->uid = $discordUser->id;
        $model->name = $discordUser->nickname;
        $model->email = $discordUser->email;
        $model->avatar = $discordUser->avatar;
        $model->token = $discordUser->token;
        $model->expires = date('Y-m-d H:i:s', time() + $discordUser->expiresIn);

        $model->save();
    }
}
