document.addEventListener('DOMContentLoaded', function () {
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

  const sidebar = document.getElementById('sidebar');
  const section = document.querySelector('section');
  let sidebarOpen = true;
  document.getElementById('icon-sidebar').addEventListener('click', () => {
    if (window.matchMedia('(max-width:768px)').matches) {
      if (sidebarOpen) {
        sidebar.style.left = '-140px';
        section.style.marginLeft = '0';
      } else {
        sidebar.style.left = '0';
        section.style.marginLeft = '140px';
      }
    }

    if (window.matchMedia('(min-width:769px)').matches) {
      if (sidebarOpen) {
        sidebar.style.left = '-200px';
        section.style.marginLeft = '0';
      } else {
        sidebar.style.left = '0';
        section.style.marginLeft = '200px';
      }
    }
    sidebarOpen = !sidebarOpen;
  });

  const inputAddImg = document.getElementById('addImage');
  inputAddImg.addEventListener('change', (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();

    const photoPreview = document.getElementById('addPhotoPreview');
    reader.onload = function (e) {
      photoPreview.setAttribute('src', `${e.target.result}`);
    };

    reader.readAsDataURL(file);
  });

  const inputEditImg = document.querySelectorAll('.input-img');
  inputEditImg.forEach((input) => {
    input.addEventListener('change', (event) => {
      const input = event.target;
      const editPhotoPreview = input.closest('.modal-body').querySelector('.editPhotoPreview');

      if (editPhotoPreview) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
          editPhotoPreview.setAttribute('src', `${e.target.result}`);
        };

        reader.readAsDataURL(file);
      }
    });
  });
});
