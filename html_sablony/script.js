const odkazyNavigace = document.getElementById('odkazy');
const otevritMobilniNavigaci = document.getElementsByClassName('otevrit')[0];
const zavritMobilniNavigaci = document.getElementsByClassName('zavrit')[0];

otevritMobilniNavigaci.addEventListener('click', () => {
    odkazyNavigace.classList.add('otevreno');
    otevritMobilniNavigaci.classList.add('otevreno');
    zavritMobilniNavigaci.classList.add('otevreno');
});

zavritMobilniNavigaci.addEventListener('click', () => {
    odkazyNavigace.classList.remove('otevreno');
    otevritMobilniNavigaci.classList.remove('otevreno');
    zavritMobilniNavigaci.classList.remove('otevreno');
});
