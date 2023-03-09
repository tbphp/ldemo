<?php

namespace App\Jobs;

use App\Enums\AssetTypeEnum;
use App\Enums\CanalEventEnum;
use App\Enums\NftClassEnum;
use App\Enums\NftGroupRewardTypeEnum;
use App\Enums\NftMintStatusEnum;
use App\Enums\NftOrderStatusEnum;
use App\Enums\TransactionEnum;
use App\Enums\WalletEnum;
use App\Models\Asset;
use App\Models\DailyStatistic;
use App\Models\ImGroup;
use App\Models\Member;
use App\Models\Nft;
use App\Models\NftFertilityRewardRecord;
use App\Models\NftGroupRewardRecord;
use App\Models\NftHpRestoreRecord;
use App\Models\NftMint;
use App\Models\NftOrder;
use App\Models\NftPatriarchCapitalInjectionRecord;
use App\Models\NftPatriarchRewardRecord;
use App\Models\NftTaskRewardRecord;
use App\Models\RedPacketLedger;
use App\Models\TradePendingFee;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class DailyStatisticsCanalJob extends AbstractCanalJob
{
    protected Carbon $updateDate;

    protected array $updateData = [];

    /**
     * @var string 手动执行，需要传入extra['manual']和extra['date']
     */
    protected string $manual = '';

    protected static array $dateColumns = [
        'assets' => 'updated_at',
        'nft_orders' => 'updated_at',
        'nft_mints' => 'updated_at',
        'transactions' => 'deal_time',
        'members' => 'updated_at',
    ];

    public static function delayKey(string $table, array $data): string
    {
        if (!empty(self::$dateColumns[$table]) && !empty($data[self::$dateColumns[$table]])) {
            $date = Date::createFromTimestamp($data[self::$dateColumns[$table]])->format('Ymd');
        } elseif (!empty($data['date'])) {
            $date = $data['date'];
        } else {
            $date = Date::createFromTimestamp($data['created_at'])->format('Ymd');
        }

        return hash('sha256', $table . '-' . $date);
    }

    public function script()
    {
        // 日期
        $column = self::$dateColumns[$this->table] ?? 'created_at';
        // 处理手动执行
        if (!empty($this->extra['manual']) && !empty($this->extra['date'])) {
            $this->manual = $this->extra['manual'];
            $this->updateDate = Date::parse($this->extra['date']);
        } elseif (!empty($this->data[$column])) {
            // 设定更新日期
            $this->updateDate = Date::createFromTimestamp($this->data[$column]);
        }

        if ($this->inTable(NftTaskRewardRecord::class) || in_array($this->manual, ['all', 'nft_task_reward_records'], true)) {
            $this->nftTaskRewardRecord();
        }

        if ($this->inTable(NftFertilityRewardRecord::class) || in_array($this->manual, ['all', 'nft_fertility_reward_records'], true)) {
            $this->nftFertilityRewardRecord();
        }

        if ($this->inTable(NftPatriarchRewardRecord::class) || in_array($this->manual, ['all', 'nft_patriarch_reward_records'], true)) {
            $this->nftPatriarchRewardRecord();
        }

        if ($this->inTable(NftGroupRewardRecord::class) || in_array($this->manual, ['all', 'nft_group_reward_records'], true)) {
            $this->nftGroupRewardRecord();
        }

        if ($this->inTable(NftPatriarchCapitalInjectionRecord::class) || in_array($this->manual, ['all', 'nft_patriarch_capital_injection_records'], true)) {
            $this->nftPatriarchCapitalInjectionRecord();
        }

        if ($this->inTable(Asset::class) || in_array($this->manual, ['all', 'assets'], true)) {
            $this->asset();
        }

        if ($this->inTable(TradePendingFee::class) || in_array($this->manual, ['all', 'trade_pending_fees'], true)) {
            $this->tradePendingFee();
        }

        if ($this->inTable(NftOrder::class) || in_array($this->manual, ['all', 'nft_orders'], true)) {
            $this->nftOrder();
        }

        if ($this->inTable(NftHpRestoreRecord::class) || in_array($this->manual, ['all', 'nft_hp_restore_records'], true)) {
            $this->nftHpRestoreRecord();
        }

        if ($this->inTable(Nft::class) || in_array($this->manual, ['all', 'nfts'], true)) {
            $this->nft();
        }

        if ($this->inTable(NftMint::class) || in_array($this->manual, ['all', 'nft_mints'], true)) {
            $this->nftMint();
        }

        if ($this->inTable(Transaction::class) || in_array($this->manual, ['all', 'transactions'], true)) {
            $this->transaction();
        }

        if ($this->inTable(Member::class) || in_array($this->manual, ['all', 'members'], true)) {
            $this->member();
        }

        if ($this->inTable(ImGroup::class) || in_array($this->manual, ['all', 'im_groups'], true)) {
            $this->imGroup();
        }

        if ($this->inTable(RedPacketLedger::class) || in_array($this->manual, ['all', 'red_packet_ledgers'], true)) {
            $this->redPacketLedger();
        }

        $this->updateData();
    }

    public function updateData()
    {
        $this->updateDate->startOfDay();
        DailyStatistic::updateOrCreate(['date' => $this->updateDate], $this->updateData);
    }

    /**
     * 任务奖
     * @return void
     */
    private function nftTaskRewardRecord()
    {
        $this->updateData['task_reward'] = NftTaskRewardRecord::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->sum('amount');
    }

    /**
     * 生育金
     * @return void
     */
    private function nftFertilityRewardRecord()
    {
        $this->updateData['fertility_reward'] = NftFertilityRewardRecord::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->sum('amount');
    }

    /**
     * 族长奖
     * @return void
     */
    private function nftPatriarchRewardRecord()
    {
        $this->updateData['patriarch_reward'] = NftPatriarchRewardRecord::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->sum('amount');
    }

    /**
     * 群组奖励
     * @return void
     */
    private function nftGroupRewardRecord()
    {
        // 群组奖励
        $groupRewards = NftGroupRewardRecord::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->groupBy('type')
            ->get(['type', DB::raw('SUM(`amount`) amount')])
            ->pluck('amount', 'type');
        if ($groupRewards->isEmpty()) {
            return;
        }

        $this->updateData['group_manager_evolve_reward'] = $groupRewards[NftGroupRewardTypeEnum::MANAGER_HP_RESTORE] ?? 0;
        $this->updateData['group_owner_evolve_reward'] = $groupRewards[NftGroupRewardTypeEnum::OWNER_HP_RESTORE] ?? 0;
        $this->updateData['group_owner_mint_reward'] = $groupRewards[NftGroupRewardTypeEnum::OWNER_MINT] ?? 0;
        $this->updateData['group_owner_mint_recommend_reward'] = $groupRewards[NftGroupRewardTypeEnum::OWNER_MINT_RECOMMEND] ?? 0;
        $this->updateData['nft_restore_hp_group_owner'] = $groupRewards[NftGroupRewardTypeEnum::OWNER_HP_RESTORE] ?? 0;
        $this->updateData['nft_restore_hp_group_manager'] = $groupRewards[NftGroupRewardTypeEnum::MANAGER_HP_RESTORE] ?? 0;
    }

    /**
     * 族长资金池
     * @return void
     */
    private function nftPatriarchCapitalInjectionRecord()
    {
        // 族长资金池数量
        $amount = NftPatriarchCapitalInjectionRecord::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->sum('injection_amount');

        $this->updateData['patriarch_capital'] = $amount;
        $this->updateData['nft_restore_hp_patriarch_capital'] = $amount;
    }

    /**
     * 资产
     * @return void
     */
    private function asset()
    {
        // 类型
        $type = (int)$this->data['type'];

        switch ($type) {
            // 系统账号
            case AssetTypeEnum::SYSTEM_ACCOUNT:
                // 恢复手续费变更
                $restoreAmount = bcsub($this->data['nft_restore_link'], $this->original['nft_restore_link'], 6);
                $this->updateData['nft_restore_hp_system_account'] = DB::raw('`nft_restore_hp_system_account` + ' . $restoreAmount);

                // Mint变更数量
                $mintAmount = bcsub($this->data['mint_cc'], $this->original['mint_cc'], 6);
                $this->updateData['nft_mint_system_account'] = DB::raw('`nft_mint_system_account` + ' . $mintAmount);
                break;
            // 市场账号
            case AssetTypeEnum::MARKET_ACCOUNT:
                // Mint变更数量
                $mintAmount = bcsub($this->data['mint_cc'], $this->original['mint_cc'], 6);
                $this->updateData['market_account'] = DB::raw('`market_account` + ' . $mintAmount);
                $this->updateData['nft_mint_market_account'] = DB::raw('`nft_mint_market_account` + ' . $mintAmount);
                break;
            // 销毁账号
            case AssetTypeEnum::DESTRUCTION_ACCOUNT:
                // Mint变更数量
                $mintAmount = bcsub($this->data['mint_cc'], $this->original['mint_cc'], 6);
                $this->updateData['destruction_account'] = DB::raw('`destruction_account` + ' . $mintAmount);
                $this->updateData['nft_mint_destruction_account'] = DB::raw('`nft_mint_destruction_account` + ' . $mintAmount);
                break;
        }
    }

    /**
     * LINK兑换手续费
     * @return void
     */
    private function tradePendingFee()
    {
        // 查询LINK兑换手续费
        $tradePendingFees = TradePendingFee::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->groupBy('coin_type')
            ->get(['coin_type', DB::raw('SUM(`trade_amount`) trade_amount'), DB::raw('SUM(`money`) money'), DB::raw('SUM(`fee`) fee')])
            ->pluck(null, 'coin_type');
        if ($tradePendingFees->isEmpty()) {
            return;
        }

        $this->updateData['trade_deal_amount'] = bcadd($tradePendingFees[WalletEnum::TYPE_USDT]['trade_amount'] ?? 0, $tradePendingFees[WalletEnum::TYPE_CC]['trade_amount'] ?? 0, 6);
        $this->updateData['trade_deal_usdt'] = $tradePendingFees[WalletEnum::TYPE_USDT]['money'] ?? 0;
        $this->updateData['trade_deal_cc'] = $tradePendingFees[WalletEnum::TYPE_CC]['money'] ?? 0;
        $this->updateData['trade_fee_usdt'] = $tradePendingFees[WalletEnum::TYPE_USDT]['fee'] ?? 0;
        $this->updateData['trade_fee_cc'] = $tradePendingFees[WalletEnum::TYPE_CC]['fee'] ?? 0;
    }

    /**
     * 赛博兔交易
     * @return void
     */
    private function nftOrder()
    {
        // 查询赛博兔订单
        $nftOrders = NftOrder::query()
            ->leftJoin('nfts', 'nfts.id', '=', 'nft_orders.nft_id')
            ->whereBetween('nft_orders.updated_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->where('nft_orders.status', NftOrderStatusEnum::SUCCESSFUL)
            ->groupBy('nfts.class')
            ->get(['nfts.class', DB::raw('SUM(`nft_orders`.`sell_price`) sell_price'), DB::raw('SUM(`nft_orders`.`fee`) fee'), DB::raw('COUNT(*) amount')])
            ->pluck(null, 'class');
        if ($nftOrders->isEmpty()) {
            return;
        }

        $this->updateData['nft_trade_money'] = $nftOrders->sum('sell_price');
        $this->updateData['nft_trade_fee'] = $nftOrders->sum('fee');
        $this->updateData['nft_trade_total_amount'] = $nftOrders->sum('amount');
        $this->updateData['nft_trade_legendary_amount'] = $nftOrders[NftClassEnum::LEGENDARY]['amount'] ?? 0;
        $this->updateData['nft_trade_epic_amount'] = $nftOrders[NftClassEnum::EPIC]['amount'] ?? 0;
        $this->updateData['nft_trade_common_amount'] = $nftOrders[NftClassEnum::COMMON]['amount'] ?? 0;
    }

    /**
     * 赛博兔生命恢复记录
     * @return void
     */
    private function nftHpRestoreRecord()
    {
        // 查询赛博兔生命恢复记录
        $nftHpRestoreRecords = NftHpRestoreRecord::query()
            ->leftJoin('nfts', 'nfts.id', '=', 'nft_hp_restore_records.nft_id')
            ->whereBetween('nft_hp_restore_records.created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->groupBy('nfts.class')
            ->get(['nfts.class', DB::raw('SUM(`nft_hp_restore_records`.`consume_amount`) consume_amount'), DB::raw('COUNT(*) amount')])
            ->pluck(null, 'class');
        if ($nftHpRestoreRecords->isEmpty()) {
            return;
        }

        $this->updateData['nft_restore_hp_total_money'] = $nftHpRestoreRecords->sum('consume_amount');
        $this->updateData['nft_restore_hp_total_amount'] = $nftHpRestoreRecords->sum('amount');
        $this->updateData['nft_restore_hp_legendary_amount'] = $nftHpRestoreRecords[NftClassEnum::LEGENDARY]['amount'] ?? 0;
        $this->updateData['nft_restore_hp_epic_amount'] = $nftHpRestoreRecords[NftClassEnum::EPIC]['amount'] ?? 0;
        $this->updateData['nft_restore_hp_common_amount'] = $nftHpRestoreRecords[NftClassEnum::COMMON]['amount'] ?? 0;
    }

    /**
     * NFT
     * @return void
     */
    private function nft()
    {
        // 查询NFT
        $nfts = Nft::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->groupBy('class')
            ->get(['class', DB::raw('COUNT(*) amount')])
            ->pluck('amount', 'class');
        if ($nfts->isEmpty()) {
            return;
        }

        $this->updateData['nft_new_total_amount'] = $nfts->sum();
        $this->updateData['nft_new_legendary_amount'] = $nfts[NftClassEnum::LEGENDARY] ?? 0;
        $this->updateData['nft_new_epic_amount'] = $nfts[NftClassEnum::EPIC] ?? 0;
        $this->updateData['nft_new_common_amount'] = $nfts[NftClassEnum::COMMON] ?? 0;
        $this->updateData['nft_new_free_amount'] = $nfts[NftClassEnum::FREE] ?? 0;
    }

    /**
     * 赛博兔Mint
     * @return void
     */
    private function nftMint()
    {
        // 查询赛博兔Mint
        $nftMints = NftMint::query()
            ->whereBetween('updated_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->where('status', NftMintStatusEnum::SUCCESSFUL)
            ->get(['child_nft_id', 'belong_node_group_id', 'consume_cc']);
        if ($nftMints->isEmpty()) {
            return;
        }

        // 查询子辈赛博兔
        $nfts = Nft::query()
            ->whereIn('id', $nftMints->pluck('child_nft_id'))
            ->groupBy('class')
            ->get(['class', DB::raw('COUNT(*) amount')])
            ->pluck('amount', 'class');

        $this->updateData['nft_mint_total_amount'] = $nfts->sum();
        $this->updateData['nft_mint_legendary_amount'] = $nfts[NftClassEnum::LEGENDARY] ?? 0;
        $this->updateData['nft_mint_epic_amount'] = $nfts[NftClassEnum::EPIC] ?? 0;
        $this->updateData['nft_mint_common_amount'] = $nfts[NftClassEnum::COMMON] ?? 0;
        $this->updateData['nft_mint_total_consume'] = $nftMints->sum('consume_cc');
        $this->updateData['node_group_consume'] = $nftMints->where('belong_node_group_id', '>', 0)->sum('consume_cc');
    }

    /**
     * 交易
     * @return void
     */
    private function transaction()
    {
        // 查询交易
        $transactions = Transaction::query()
            ->whereBetween('deal_time', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->whereIn('coin_type', [WalletEnum::TYPE_USDT, WalletEnum::TYPE_CC])
            ->groupBy(['coin_type', 'type'])
            ->get(['coin_type', 'type', DB::raw('SUM(`amount`) amount'), DB::raw('SUM(`fee`) fee')])
            ->mapWithKeys(function (Transaction $model) {
                return [sprintf('%d-%d', $model->coin_type, $model->type) => $model];
            });
        if ($transactions->isEmpty()) {
            return;
        }

        $this->updateData['transaction_in_usdt'] = $transactions[WalletEnum::TYPE_USDT . '-' . TransactionEnum::TYPE_RECHARGE]['amount'] ?? 0;
        $this->updateData['transaction_in_cc'] = $transactions[WalletEnum::TYPE_CC . '-' . TransactionEnum::TYPE_RECHARGE]['amount'] ?? 0;
        $this->updateData['transaction_out_usdt'] = $transactions[WalletEnum::TYPE_USDT . '-' . TransactionEnum::TYPE_WITHDRAW]['amount'] ?? 0;
        $this->updateData['transaction_out_cc'] = $transactions[WalletEnum::TYPE_CC . '-' . TransactionEnum::TYPE_WITHDRAW]['amount'] ?? 0;
        $this->updateData['transaction_fee'] = $transactions->sum('fee');
    }

    /**
     * 用户
     * @return void
     */
    private function member()
    {
        // 新增
        if ($this->event->is(CanalEventEnum::INSERT)) {
            $this->updateData['new_member_amount'] = Member::query()
                ->whereBetween('created_at', [
                    $this->updateDate->copy()->startOfDay()->timestamp,
                    $this->updateDate->copy()->endOfDay()->timestamp,
                ])
                ->count();
            return;
        }

        // 更新
        $frees = [0, NftClassEnum::FREE];
        if (in_array($this->original['grade'], $frees) && !in_array($this->data['grade'], $frees)) {
            $this->updateData['new_adv_member_amount'] = DB::raw('`new_adv_member_amount` + 1');
        }
        if (!in_array($this->original['grade'], $frees) && in_array($this->data['grade'], $frees)) {
            $this->updateData['new_adv_member_amount'] = DB::raw('`new_adv_member_amount` - 1');
        }
    }

    /**
     * 群组
     * @return void
     */
    private function imGroup()
    {
        $this->updateData['new_group_amount'] = ImGroup::query()
            ->whereBetween('created_at', [
                $this->updateDate->copy()->startOfDay()->timestamp,
                $this->updateDate->copy()->endOfDay()->timestamp,
            ])
            ->count();
    }

    /**
     * 红包
     * @return void
     */
    private function redPacketLedger()
    {
        // 操作
        $operate = (int)$this->data['operate'];
        // 数量
        $amount = abs($this->data['amount']);

        // 发出红包
        if ($operate === RedPacketLedger::OPERATE_RED_PACKET_DISTRIBUTE) {
            $this->updateData['red_packet_total'] = DB::raw('`red_packet_total` + ' . $amount);
        }

        // 已领取红包
        if ($operate === RedPacketLedger::OPERATE_RED_PACKET_RECEIVE) {
            $this->updateData['red_packet_received'] = DB::raw('`red_packet_received` + ' . $amount);
        }

        // 退款红包
        if ($operate === RedPacketLedger::OPERATE_RED_PACKET_REFUND) {
            $this->updateData['red_packet_refund'] = DB::raw('`red_packet_refund` + ' . $amount);
        }
    }
}
