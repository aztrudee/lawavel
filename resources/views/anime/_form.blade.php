<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Genre</label>
    <input type="text" name="genre" class="form-control" placeholder="e.g. Action, Romance, Isekai" required>
</div>
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="">Select status</option>
        <option value="Watching">Watching</option>
        <option value="Completed">Completed</option>
        <option value="Plan to Watch">Plan to Watch</option>
        <option value="Dropped">Dropped</option>
    </select>
</div>
<div class="row">
    <div class="col-6 mb-3">
        <label class="form-label">Episodes</label>
        <input type="number" name="episodes" class="form-control" min="0" value="0" required>
    </div>
    <div class="col-6 mb-3">
        <label class="form-label">Rating <small style="color:#666">(1–10)</small></label>
        <input type="number" name="rating" class="form-control" min="1" max="10" placeholder="Optional">
    </div>
</div>
