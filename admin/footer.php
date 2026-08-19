    </div><!-- /.content -->
  </div>
</div>
<!-- image preview modal -->
<div class="img-modal" id="imgModal" onclick="this.classList.remove('show')">
  <img id="imgModalImg" src="" alt="Preview">
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // click any .thumb / .img-zoom to open preview modal
  document.addEventListener('click', function (e) {
    const t = e.target.closest('.thumb, .img-zoom');
    if (t && t.tagName === 'IMG') {
      document.getElementById('imgModalImg').src = t.src;
      document.getElementById('imgModal').classList.add('show');
    }
  });
  // live image preview on file inputs (class .preview-input with data-preview target)
  document.addEventListener('change', function (e) {
    const inp = e.target;
    if (inp.matches('.preview-input') && inp.files && inp.files[0]) {
      const reader = new FileReader();
      reader.onload = function (ev) {
        const box = document.querySelector(inp.dataset.preview || '#previewBox');
        if (box) { box.innerHTML = '<img src="' + ev.target.result + '" alt="preview">'; }
      };
      reader.readAsDataURL(inp.files[0]);
    }
  });
</script>
</body>
</html>
