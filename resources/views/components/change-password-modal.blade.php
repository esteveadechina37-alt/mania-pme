<div id="changePasswordModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 480px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px;">Mise à jour de vos identifiants</h3>
        </div>
        <p style="margin-bottom: 16px; font-size: 14px; color: var(--gray-600);">
            Pour des raisons de sécurité, vous devez modifier votre mot de passe et éventuellement votre adresse email avant de continuer.
        </p>
        <form method="POST" action="{{ route('credentials.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="form-input">
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="password" required class="form-input">
            </div>
            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required class="form-input">
            </div>
            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    // Afficher la modale si la session le demande
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('show_password_modal'))
            document.getElementById('changePasswordModal').style.display = 'flex';
        @endif
    });
</script>

<style>
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.5);
        display: flex; align-items: center; justify-content: center;
        z-index: 10000; backdrop-filter: blur(4px);
    }
    .modal-content {
        background: white; border-radius: 14px; padding: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        width: 90%;
    }
    .form-group { margin-bottom: 16px; }
    .form-input {
        width: 100%; padding: 10px 14px; border: 1px solid #ddd;
        border-radius: 6px; font-size: 14px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #FF6200, #E05500);
        color: white; padding: 10px 20px; border-radius: 9999px;
        font-weight: 600; font-size: 14px; border: none; cursor: pointer;
        box-shadow: 0 4px 12px rgba(255,98,0,0.25);
    }
</style>