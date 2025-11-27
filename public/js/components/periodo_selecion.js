document.addEventListener('click', e => {
    if (e.target.matches("[name='periodo_seleccion']")) {
        let dateRangeReport = document.querySelector('.data-range-report');
        if (e.target.value == 0) {
            dateRangeReport.style.display = 'block';
        } else {
            dateRangeReport.style.display = 'none';
        }
    }
})