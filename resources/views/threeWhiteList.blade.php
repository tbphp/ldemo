<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.1/jquery.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
</head>
<body>

<div class="container-fluid pt-3">
    <!-- 操作 -->
    <div class="flex pb-3">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">新增</button>
        <button type="button" class="btn btn-info" onclick="download()">导出</button>
    </div>

    <!-- 列表 -->
    <div class="card">
        <div class="card-header">
            累计已添加 Common: {{ $sum['common_total_amount'] }}个, Epic: {{ $sum['epic_total_amount'] }}个, Legendary: {{ $sum['legendary_total_amount'] }}个。
            <br/>
            累计已购买 Common: {{ $sum['common_buy_amount'] }}个, Epic: {{ $sum['epic_buy_amount'] }}个, Legendary: {{ $sum['legendary_buy_amount'] }}个。
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">授权邮箱</th>
                    <th scope="col">白名单邮箱</th>
                    <th scope="col">Common数量(已购买/总量)</th>
                    <th scope="col">Epic数量(已购买/总量)</th>
                    <th scope="col">Legendary数量(已购买/总量)</th>
                    <th scope="col">添加时间</th>
                    <th scope="col">更新时间</th>
                    <th scope="col">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr>
                    <td hidden class="id" data-value="{{ $item['id'] }}">{{ $item['id'] }}</td>
                    <td class="auth_email" data-value="{{ $item['auth_email'] }}">{{ $item['auth_email'] }}</td>
                    <td class="white_email" data-value="{{ $item['white_email'] }}">{{ $item['white_email'] }}</td>
                    <td class="common_total_amount" data-value="{{ $item['common_total_amount'] }}">{{ $item['common_buy_amount'] }}/{{ $item['common_total_amount'] }}</td>
                    <td class="epic_total_amount" data-value="{{ $item['epic_total_amount'] }}">{{ $item['epic_buy_amount'] }}/{{ $item['epic_total_amount'] }}</td>
                    <td class="legendary_total_amount" data-value="{{ $item['legendary_total_amount'] }}">{{ $item['legendary_buy_amount'] }}/{{ $item['legendary_total_amount'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['updated_at'] }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="editModal(this)">编辑</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 新增 -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">添加白名单</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="auth_email" class="form-label">授权邮箱</label>
                            <input type="email" class="form-control" id="auth_email" placeholder="21个超级节点或其他授权邮箱">
                        </div>
                        <div class="mb-3">
                            <label for="white_email" class="form-label">白名单邮箱</label>
                            <input type="email" class="form-control" id="white_email" placeholder="享有购买赛博兔NFT资格的邮箱">
                        </div>
                        <div class="mb-3">
                            <label for="common_total_amount" class="form-label">Common数量</label>
                            <input type="number" class="form-control" id="common_total_amount" placeholder="可购买Common个数">
                        </div>
                        <div class="mb-3">
                            <label for="epic_total_amount" class="form-label">Epic数量</label>
                            <input type="number" class="form-control" id="epic_total_amount" placeholder="可购买Epic个数">
                        </div>
                        <div class="mb-3">
                            <label for="legendary_total_amount" class="form-label">Legendary数量</label>
                            <input type="number" class="form-control" id="legendary_total_amount" placeholder="可购买Legendary个数">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="add()">保存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 修改 -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">修改白名单</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="id">
                        <div class="mb-3">
                            <label for="auth_email" class="form-label">授权邮箱</label>
                            <input type="email" class="form-control" id="auth_email" placeholder="21个超级节点或其他授权邮箱">
                        </div>
                        <div class="mb-3">
                            <label for="white_email" class="form-label">白名单邮箱</label>
                            <input type="email" class="form-control" id="white_email" placeholder="享有购买赛博兔NFT资格的邮箱" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="common_total_amount" class="form-label">Common数量</label>
                            <input type="number" class="form-control" id="common_total_amount" placeholder="可购买Common个数">
                        </div>
                        <div class="mb-3">
                            <label for="epic_total_amount" class="form-label">Epic数量</label>
                            <input type="number" class="form-control" id="epic_total_amount" placeholder="可购买Epic个数">
                        </div>
                        <div class="mb-3">
                            <label for="legendary_total_amount" class="form-label">Legendary数量</label>
                            <input type="number" class="form-control" id="legendary_total_amount" placeholder="可购买Legendary个数">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="edit()">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(function () {
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-top-center",
        };
    });

    // 锁定
    let requestLock = false;
    let exportLock = false;

    // 添加
    function add() {
        // 数据
        let values = {
            auth_email: $('#addModal #auth_email').val(),
            white_email: $('#addModal #white_email').val(),
            common_total_amount: $('#addModal #common_total_amount').val(),
            epic_total_amount: $('#addModal #epic_total_amount').val(),
            legendary_total_amount: $('#addModal #legendary_total_amount').val(),
        };
        // 请求
        request(values, 'post');
    }

    // 导出
    function download() {
        // 锁定验证
        if (exportLock) {
            return;
        }
        exportLock = true;

        // 导出
        location.href = location.href + '?export=1';

        setTimeout(() => {
            exportLock = false;
        }, 3000);
    }

    // 编辑弹窗
    function editModal(obj) {
        // 弹窗实例
        let modal = new bootstrap.Modal(document.getElementById('editModal'));

        // 添加数据
        let dataDom = $(obj).parents('tr');
        $('#editModal #id').val(dataDom.find('.id').data('value'));
        $('#editModal #auth_email').val(dataDom.find('.auth_email').data('value'));
        $('#editModal #white_email').val(dataDom.find('.white_email').data('value'));
        $('#editModal #common_total_amount').val(dataDom.find('.common_total_amount').data('value'));
        $('#editModal #epic_total_amount').val(dataDom.find('.epic_total_amount').data('value'));
        $('#editModal #legendary_total_amount').val(dataDom.find('.legendary_total_amount').data('value'));

        // 显示
        modal.show();
    }

    // 编辑
    function edit() {
        // 数据
        let values = {
            id: $('#editModal #id').val(),
            auth_email: $('#editModal #auth_email').val(),
            common_total_amount: $('#editModal #common_total_amount').val(),
            epic_total_amount: $('#editModal #epic_total_amount').val(),
            legendary_total_amount: $('#editModal #legendary_total_amount').val(),
        };
        // 请求
        request(values, 'put');
    }

    // 请求
    function request(data, method) {
        // 锁定验证
        if (requestLock) {
            return;
        }
        requestLock = true;

        $.ajax({
            url: location.href,
            method: method,
            dataType: 'json',
            headers: {
                'X-Lang': 'zh-CN',
            },
            data: data,
            success: (res) => {
                if (res.code && res.code !== 1) {
                    toastr.warning(res.msg)
                    return;
                }

                // 刷新
                location.reload();
            },
            complete: () => {
                requestLock = false;
            },
        });
    }
</script>
</html>
