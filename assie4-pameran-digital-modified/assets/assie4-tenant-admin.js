(function () {
  'use strict';
  var input = document.getElementById('t_logo_file');
  var preview = document.getElementById('a4-logo-preview');
  var status = document.getElementById('a4-logo-status');
  var code = document.getElementById('t_id');
  var area = document.getElementById('t_area');
  var objectUrl;
  if (code) code.addEventListener('input', function () {
    code.value = code.value.toUpperCase();
    if (/^[A-H]/.test(code.value) && area) area.value = code.value.charAt(0);
  });
  if (!input || !preview) return;
  var original = preview.src;
  input.addEventListener('change', function () {
    if (objectUrl) URL.revokeObjectURL(objectUrl);
    var file = input.files[0];
    preview.hidden = !file && !preview.dataset.hasLogo;
    if (!file) { preview.src = original; status.textContent = 'Logo saat ini dipertahankan.'; return; }
    if (!/^image\/(png|jpeg|webp|gif)$/.test(file.type)) {
      input.value = ''; status.textContent = 'Pilih file PNG, JPG, WebP, atau GIF.'; preview.hidden = true; return;
    }
    objectUrl = URL.createObjectURL(file);
    preview.src = objectUrl;
    preview.hidden = false;
    status.textContent = file.name + ' — akan di-upload saat booth disimpan.';
  });
  preview.addEventListener('error', function () {
    preview.hidden = true;
    status.textContent = 'Logo tidak bisa dimuat. Pilih file baru untuk menggantinya.';
  });
  var remove = document.getElementById('t_remove_logo');
  if (remove) remove.addEventListener('change', function () {
    preview.hidden = remove.checked;
    status.textContent = remove.checked ? 'Logo akan dihapus saat booth disimpan.' : 'Logo saat ini dipertahankan.';
  });
})();
