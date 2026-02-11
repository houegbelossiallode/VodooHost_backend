document.getElementById('contactHostForm').addEventListener('submit', async function (e) {
  e.preventDefault();
  const form = e.target;
  const result = document.getElementById('contactResult');
  result.innerHTML = '';

  const formData = new FormData(form); // contient _token grâce à @csrf

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }, // pour 422 JSON
      body: formData
    });

    // Tenter de parser le JSON quelle que soit la réponse
    let data = {};
    try { data = await response.json(); } catch (_) {}

    if (response.ok) {
      result.innerHTML = `<div class="alert alert-success">${data.message ?? 'Message envoyé avec succès.'}</div>`;
      form.reset();
    } else if (response.status === 422 && data.errors) {
      // Afficher joliment les erreurs de validation Laravel
      const list = Object.values(data.errors).flat().map(e => `<li>${e}</li>`).join('');
      result.innerHTML = `<div class="alert alert-danger"><ul class="mb-0">${list}</ul></div>`;
    } else {
      result.innerHTML = `<div class="alert alert-danger">${data.message ?? 'Erreur lors de l’envoi.'}</div>`;
    }
  } catch (err) {
    result.innerHTML = `<div class="alert alert-danger">Erreur réseau : ${err.message}</div>`;
  }
});