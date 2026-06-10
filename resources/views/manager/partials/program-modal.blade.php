<!-- Modal création programme -->
<div id="createProgramModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:20px; width:90%; max-width:500px; max-height:80vh; overflow-y:auto;">
        <h3 style="margin-bottom:16px;">Nouveau programme hebdomadaire</h3>
            <form method="POST" action="{{ route('manager.team.program.store') }}">
                @csrf
            <input type="text" name="title" placeholder="Titre (ex: Programme du 8 au 14 juin)" required style="width:100%; padding:8px; margin-bottom:10px; border:1px solid #ddd; border-radius:6px;">
            <textarea name="description" placeholder="Description générale" style="width:100%; padding:8px; margin-bottom:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
            <div id="objectivesContainer">
                <label style="font-weight:600;">Objectifs</label>
                <div class="objective-group" style="margin-bottom:8px;">
                    <input type="text" name="objectives[0][description]" placeholder="Description de l'objectif" required style="width:70%; padding:6px; border:1px solid #ddd; border-radius:4px;">
                    <input type="number" name="objectives[0][target]" placeholder="Cible (optionnel)" step="0.01" style="width:25%; padding:6px; border:1px solid #ddd; border-radius:4px;">
                </div>
            </div>
            <button type="button" onclick="addObjective()" style="margin-top:6px; background:var(--primary); color:white; border:none; padding:4px 12px; border-radius:6px; font-size:12px;">+ Ajouter un objectif</button>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:16px;">
                <button type="button" onclick="this.closest('#createProgramModal').style.display='none'" style="background:var(--gray-200); border:none; padding:8px 16px; border-radius:6px;">Annuler</button>
                <button type="submit" style="background:var(--primary); color:white; border:none; padding:8px 16px; border-radius:6px;">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal modification (similaire mais pré-rempli avec $currentWeekProgram) -->
@if(isset($currentWeekProgram))
<div id="editProgramModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:20px; width:90%; max-width:500px;">
        <h3 style="margin-bottom:16px;">Modifier le programme</h3>
        <form method="POST" action="{{ route('manager.team.program.store') }}">
            @csrf
            <input type="text" name="title" value="{{ $currentWeekProgram->title }}" required style="width:100%; padding:8px; margin-bottom:10px; border:1px solid #ddd; border-radius:6px;">
            <textarea name="description" style="width:100%; padding:8px; margin-bottom:10px; border:1px solid #ddd; border-radius:6px;">{{ $currentWeekProgram->description }}</textarea>
            <div id="editObjectivesContainer">
                <label style="font-weight:600;">Objectifs</label>
                @foreach($currentWeekProgram->objectives as $i => $obj)
                    <div class="objective-group" style="margin-bottom:8px;">
                        <input type="text" name="objectives[{{ $i }}][description]" value="{{ $obj->description }}" required style="width:70%; padding:6px; border:1px solid #ddd; border-radius:4px;">
                        <input type="number" name="objectives[{{ $i }}][target]" value="{{ $obj->target }}" step="0.01" style="width:25%; padding:6px; border:1px solid #ddd; border-radius:4px;">
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addObjectiveEdit()" style="margin-top:6px; background:var(--primary); color:white; border:none; padding:4px 12px; border-radius:6px; font-size:12px;">+ Ajouter un objectif</button>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:16px;">
                <button type="button" onclick="this.closest('#editProgramModal').style.display='none'" style="background:var(--gray-200); border:none; padding:8px 16px; border-radius:6px;">Annuler</button>
                <button type="submit" style="background:var(--primary); color:white; border:none; padding:8px 16px; border-radius:6px;">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
function addObjective() {
    const container = document.getElementById('objectivesContainer');
    const index = container.querySelectorAll('.objective-group').length;
    const html = `<div class="objective-group" style="margin-bottom:8px;">
        <input type="text" name="objectives[${index}][description]" placeholder="Description" required style="width:70%; padding:6px; border:1px solid #ddd; border-radius:4px;">
        <input type="number" name="objectives[${index}][target]" placeholder="Cible" step="0.01" style="width:25%; padding:6px; border:1px solid #ddd; border-radius:4px;">
        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:red; cursor:pointer;">&times;</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function addObjectiveEdit() {
    const container = document.getElementById('editObjectivesContainer');
    const index = container.querySelectorAll('.objective-group').length;
    const html = `<div class="objective-group" style="margin-bottom:8px;">
        <input type="text" name="objectives[${index}][description]" placeholder="Description" required style="width:70%; padding:6px; border:1px solid #ddd; border-radius:4px;">
        <input type="number" name="objectives[${index}][target]" placeholder="Cible" step="0.01" style="width:25%; padding:6px; border:1px solid #ddd; border-radius:4px;">
        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:red; cursor:pointer;">&times;</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>