// document.addEventListener('DOMContentLoaded', function() {
//         // Gestion du téléchargement de la photo
//         const photoInput = document.querySelector('input[name="photo"]');
//         if (photoInput) {
//             photoInput.addEventListener('change', function() {
//                 if (this.files && this.files[0]) {
//                     // Afficher un indicateur de chargement
//                     const img = document.getElementById('profile-photo');
//                     const originalSrc = img.src;
//                     img.src = 'data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH+GkNyZWF0ZWQgd2l0aCBhamF4bG9hZC5pbmZvACH5BAAKAAAAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQACgABACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkEAAoAAgAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkEAAoAAwAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkEAAoABAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQACgAFACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQACgAGACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCIBWWCICRZYYmCCe8c4hsNwJf16iB2KguhIQ0cCwSxBgCDh0lCNAACH5BAAKAAcALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==';
                    
//                     // Créer un FormData et envoyer la requête
//                     const formData = new FormData();
//                     formData.append('photo', this.files[0]);
//                     formData.append('_token', '{{ csrf_token() }}');
                    
//                     fetch('{{ route("profile.update-photo") }}', {
//                         method: 'POST',
//                         body: formData
//                     })
//                     .then(response => response.json())
//                     .then(data => {
//                         console.log(data);
//                         if (data.success) {
//                             img.src = data.photo_url;
//                         } else {
//                             img.src = originalSrc;
//                             alert('Erreur lors du téléchargement de la photo');
//                         }
//                     })
//                     .catch(error => {
//                         console.error('Error:', error);
//                         img.src = originalSrc;
//                         alert('Une erreur est survenue');
//                     });
//                 }
//             });
//         }
// });

document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.querySelector('input[name="photo"]');
    if (photoInput) {
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const img = document.getElementById('profile-photo');
                const originalSrc = img.src;

                // Loader gif
                img.src = 'data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH+GkNyZWF0ZWQgd2l0aCBhamF4bG9hZC5pbmZvACH5BAAKAAAAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQACgABACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkEAAoAAgAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkEAAoAAwAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkEAAoABAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQACgAFACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQACgAGACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCIBWWCICRZYYmCCe8c4hsNwJf16iB2KguhIQ0cCwSxBgCDh0lCNAACH5BAAKAAcALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==';

                const formData = new FormData();
                formData.append('photo', this.files[0]);

                fetch(window.profileUpdatePhotoUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': window.csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json().catch(() => null);

                    if (response.ok && data && data.success) {
                        img.src = data.photo_url;

                        //SweetAlert succès
                        Swal.fire({
                            icon: 'success',
                            title: 'Photo mise à jour',
                            text: data.message || 'Votre photo de profil a été mise à jour avec succès.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        img.src = originalSrc;

                        if (data && data.errors) {
                            const erreursPhoto = data.errors.photo || [];
                            const message = erreursPhoto[0] || 'Erreur de validation';

                            //SweetAlert erreur de validation
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: message
                            });
                        } else {
                            //SweetAlert erreur générique
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Erreur lors du téléchargement de la photo.'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    img.src = originalSrc;

                    //SweetAlert pour les erreurs réseau / inattendues
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue. Veuillez réessayer.'
                    });
                });
            }
        });
    }
});


