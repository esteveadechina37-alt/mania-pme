<!-- Modal overlay -->
<div class="modal-overlay" id="confirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:32px; max-width:420px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="font-size:48px; margin-bottom:16px;">
            <i class="fas fa-exclamation-triangle" style="color:#FF6200;"></i>
        </div>
        <h3 style="font-family:'Clash Display', sans-serif; margin:0 0 8px;">Confirmer la suppression</h3>
        <p style="color:#6B6B6B; margin:0 0 24px;" id="modalMessage">Cette action est irréversible. Voulez-vous vraiment continuer ?</p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button id="modalCancel" style="background:#eee; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">Annuler</button>
            <button id="modalConfirm" style="background:#DC2626; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">Supprimer définitivement</button>
        </div>
    </div>
</div>