<?php

namespace App\Models;

use App\Enums\NftClassEnum;
use App\Events\MemberCreatedEvent;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use ModelAnnotate, HasFactory, Notifiable;

    public $incrementing = false;

    protected $perPage = 10;

    protected $dateFormat = 'U';

    protected $guarded = [];

    protected $hidden = ['pivot', 'node_group_id', 'grade', 'pid', 'default_avatar'];

    protected $appends = ['checksum_address'];

    /**
     * @var bool 标记当前模型创建事件是否异步队列，如果为false则同步处理
     */
    public bool $eventOnQueue = true;

    protected $casts = [
        'grade' => 'integer',
        'is_city_node' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => MemberCreatedEvent::class,
    ];

    public function __construct(array $attributes = [])
    {
        if (isset($attributes['eventOnQueue'])) {
            $this->eventOnQueue = (bool)$attributes['eventOnQueue'];
            unset($attributes['eventOnQueue']);
        }
        parent::__construct($attributes);
    }

    protected static function booted()
    {
        static::creating(function (Member $member) {
            if (!$member->id) {
                while (true) {
                    if (App::environment('production')) {
                        $id = mt_rand(1000000000, 9999999999);
                    } else {
                        $id = mt_rand(100000000, 999999999);
                    }
                    if (!Member::find($id)) {
                        $member->id = $id;
                        break;
                    }
                }
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date): int
    {
        return $date->getTimestamp();
    }

    /**
     * 修改器
     *
     * @param $value
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getChecksumAddressAttribute(): string
    {
        if (empty($this->attributes['address'])) {
            return '';
        }
        return toChecksum($this->attributes['address']);
    }

    public function getAvatarAttribute(): string
    {
        if (empty($this->attributes['avatar'])) {
            return '';
        }
        return Storage::disk('nft')->url($this->attributes['avatar']);
    }

    public function getDefaultAvatarAttribute(): string
    {
        if (empty($this->attributes['default_avatar'])) {
            return '';
        }
        return Storage::disk('nft')->url($this->attributes['default_avatar']);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'pid');
    }

    public function avatarNft(): BelongsTo
    {
        return $this->belongsTo(Nft::class, 'avatar_nft_no', 'no');
    }

    /**
     * 聊天好友多对多关联
     *
     * @return BelongsToMany
     */
    public function imFriends(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'im_friends', null, 'friend_member_id');
    }

    /**
     * 加入的群
     *
     * @return BelongsToMany
     */
    public function imGroups(): BelongsToMany
    {
        return $this->belongsToMany(ImGroup::class)
            ->using(ImGroupMember::class)
            ->withTimestamps()
            ->withPivot(['identity', 'source_member_id']);
    }

    /**
     * 节点群
     *
     * @return BelongsTo
     */
    public function nodeGroup(): BelongsTo
    {
        return $this->belongsTo(ImGroup::class, 'node_group_id');
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class, 'member_id');
    }

    public function nfts(): HasMany
    {
        return $this->hasMany(Nft::class, 'member_id');
    }

    public function commonNfts(): HasMany
    {
        return $this->hasMany(Nft::class)
            ->where('class', NftClassEnum::COMMON);
    }

    public function epicNfts(): HasMany
    {
        return $this->hasMany(Nft::class)
            ->where('class', NftClassEnum::EPIC);
    }

    public function legendaryNfts(): HasMany
    {
        return $this->hasMany(Nft::class)
            ->where('class', NftClassEnum::LEGENDARY);
    }

    public function freeNfts(): HasMany
    {
        return $this->hasMany(Nft::class)
            ->where('class', NftClassEnum::FREE);
    }

    public function redPacketLedgers(): HasMany
    {
        return $this->hasMany(RedPacketLedger::class);
    }
}
