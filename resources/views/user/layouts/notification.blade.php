@if(session('success'))
<div class="custom-modal" id="successModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header success">
            <i class="fas fa-check-circle"></i>
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
            <i class="fas fa-exclamation-circle"></i>
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
    }

    .custom-modal-header {
        padding: 25px 20px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #F5F6F5;
    }

    .custom-modal-header.success,
    .custom-modal-header.error {
        background: transparent;
    }

    .custom-modal-header.success i {
        color: #4CAF50;
        font-size: 95px;
    }

    .custom-modal-header.error i {
        color: #D32F2F;
        font-size: 95px;
    }

    .custom-modal-body {
        padding: 10px 20px;
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

    .modal-button {
        width: 100px;
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
        background: #D32F2F;
    }

    .error-button:hover {
        background: #B71C1C;
    }

    .modal-button:focus,
    .success-button:focus,
    .error-button:focus,
    .cancel-button:focus {
        outline: none;
    }
    
</style>

<script>
    $(document).ready(function() {
        $('#successModal').fadeIn();
        $('#errorModal').fadeIn();
    });
</script>