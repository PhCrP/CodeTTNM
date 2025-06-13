@if(session('success'))
<div class="custom-modal" id="successModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header success">
            <span class="modal-title-text">Thông báo</span>
            <i class="fa fa-check-circle"></i>
            <span class="close-modal" onclick="$('#successModal').fadeOut();">×</span>
        </div>
        <div class="custom-modal-body">
            {{ session('success') }}
        </div>
        <div class="custom-modal-footer">
            <button class="modal-button success-button" onclick="$('#successModal').fadeOut();">OK</button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="custom-modal" id="errorModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header error">
            <span class="modal-title-text">Lỗi</span>
            <i class="fa fa-exclamation-circle"></i>
            <span class="close-modal" onclick="$('#errorModal').fadeOut();">×</span>
        </div>
        <div class="custom-modal-body">
            {{ session('error') }}
        </div>
        <div class="custom-modal-footer">
            <button class="modal-button error-button" onclick="$('#errorModal').fadeOut();">OK</button>
        </div>
    </div>
</div>
@endif

@if(session('confirm_delete'))
<div class="custom-modal" id="deleteModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header confirm-del">
            <span class="modal-title-text">Xác nhận xóa</span>
            <i class="fa fa-question-circle"></i>
            <span class="close-modal" onclick="$('#deleteModal').fadeOut();">×</span>
        </div>
        <div class="custom-modal-body">
            Bạn có chắc chắn muốn xóa <strong>{{ session('confirm_delete')['title'] }}</strong> khỏi giỏ hàng không?
        </div>
        <div class="custom-modal-footer confirms">
            <form action="{{ route('cart-delete', session('confirm_delete')['id']) }}" method="GET">
                <button type="submit" class="modal-button success-button">Xác nhận</button>
            </form>
            <button class="modal-button error-button" onclick="$('#deleteModal').fadeOut();">Hủy</button>
        </div>
    </div>
</div>
@endif

<style>
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(51, 51, 51, 0.5);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background: #F5F6F5;
        padding: 0px 40px;
        width: 90%;
        max-width: 400px;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: slideIn 0.3s ease-in-out;
    }

    .custom-modal-header {
        position: relative;
        padding: 20px 20px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: transparent;
    }

    .modal-title-text {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .close-modal {
        position: absolute;
        top: 13px;
        right: -18px;
        font-size: 30px;
        cursor: pointer;
        color: #333;
    }

    .custom-modal-header.success i {
        color: #4CAF50;
        font-size: 80px;
    }

    .custom-modal-header.error i {
        color: #D32F2F;
        font-size: 80px;
    }

    .custom-modal-header.confirm-del i {
        color: #ffc107;
        font-size: 80px;
    }

    .custom-modal-body {
        padding: 10px 20px 15px;
        text-align: center;
        font-size: 16px;
        color: #333333;
    }

    .custom-modal-footer {
        padding: 10px 0 15px;
        text-align: center;
        border-top: 1px solid #e0e0e0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .custom-modal-footer.confirms {
        width: auto;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .modal-button {
        padding: 8px 16px;
        width: 130px;
        height: 45px;
        color: #F5F6F5;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }

    .success-button {
        background: #4A90E2;
    }

    .success-button:hover {
        background: #357ABD;
    }

    .error-button {
        background: #4A90E2;
    }

    .error-button:hover {
        background: #357ABD;
    }

    .modal-button:focus,
    .success-button:focus,
    .error-button:focus {
        outline: none;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<script>
    $(document).ready(function() {
        $('#successModal').fadeIn();
        $('#errorModal').fadeIn();
        $('#deleteModal').fadeIn();
    });
</script>