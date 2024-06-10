document.addEventListener('DOMContentLoaded', () => {
  const containerProducts = document.getElementById('products-card');
  var keyword = document.getElementById('keyword');
  keyword.addEventListener('input', () => {
    // buat object ajax
    const xhr = new XMLHttpRequest();

    // cek kesiapan ajax
    xhr.onreadystatechange = () => {
      if (xhr.readyState == 4 && xhr.status == 200) {
        containerProducts.innerHTML = xhr.responseText;
      }
    };

    // ekskusi ajax
    xhr.open('GET', '../../../js/ajax/livesearch/products.php?keyword=' + keyword.value, true);
    xhr.send();
  });
});
