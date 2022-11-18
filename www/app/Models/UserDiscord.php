<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TraitUuid;

use Illuminate\Support\Facades\Http;

class UserDiscord extends User
{
    use HasFactory, SoftDeletes, TraitUuid;

    protected $table = 'users_discord';

    /**
     * 取得所在的伺服器清單
     */
    public function listGuilds()
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])
            ->get('https://discord.com/api/users/@me/guilds');

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * 取得伺服器內個人資料
     */
    public function getGuildInfo($guildId)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}"
        ])
            ->get("https://discord.com/api/users/@me/guilds/{$guildId}/member");

        return json_decode((string) $response->getBody(), true);
    }
}
