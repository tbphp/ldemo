<?php

namespace App\Jobs;

use App\Models\Member;
use App\Services\Im\Api;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MemberCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function handle()
    {
        // 创建im用户
        $check = Api::request('im_open_login_svc/account_check', [
            'CheckItem' => [[
                'UserID' => (string)$this->member->id,
            ]],
        ]);
        if (($check['ResultItem'][0]['AccountStatus'] ?? 'NotImported') !== 'Imported') {
            Api::request('im_open_login_svc/account_import', [
                'UserID' => (string)$this->member->id,
                'Nick' => $this->member->nickname,
                'FaceUrl' => $this->member->avatar,
            ]);
        }

        Api::request('profile/portrait_set', [
            'From_Account' => (string)$this->member->id,
            'ProfileItem' => [
                [
                    'Tag' => 'Tag_Profile_IM_Nick',
                    'Value' => $this->member->nickname,
                ],
                [
                    'Tag' => 'Tag_Profile_IM_Image',
                    'Value' => $this->member->avatar,
                ],
                [
                    'Tag' => 'Tag_Profile_Custom_Address',
                    'Value' => $this->member->address,
                ],
            ],
        ]);

        // 发送欢迎消息
        if (config('im.cs_account')) {
            Api::request('openim/sendmsg', [
                'SyncOtherMachine' => 2,
                'From_Account' => (string)config('im.cs_account'),
                'To_Account' => (string)$this->member->id,
                'MsgSeq' => mt_rand(0, 4294967295),
                'MsgRandom' => mt_rand(0, 4294967295),
                'MsgBody' => [[
                    'MsgType' => 'TIMTextElem',
                    'MsgContent' => [
                        'Text' => __('im.welcome', [], $this->member->lang),
                    ],
                ]],
            ]);
        }
    }
}
