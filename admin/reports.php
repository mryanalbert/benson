<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <div class="d-flex">
        <select name="ac-year-filter" id="ac-year-filter" class="form-select form-select-sm" style="width:140px;"></select>
        <select name="sem-filter" id="sem-filter" class="form-select ms-2 form-select-sm" style="width:160px;"></select>
        <select name="month-filter" id="month-filter" class="form-select ms-2 form-select-sm" style="width:115px;"></select>
        <select name="dep-filter" id="dep-filter" class="form-select ms-2 form-select-sm" style="width:100px;"></select>
        <select name="faculty-filter" id="faculty-filter" class="form-select ms-2 form-select-sm" style="width:200px;"></select>

        <button class="btn btn-secondary ms-2" id="filter-scheds-btn">Filter</button>
      </div>
    </div>
  </div>
</main>
<?php require_once './assets/footer.php'; ?>
<script>
  $(document).ready(async () => {
    function swal(icon, title, text) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text,
      })
    }

    async function fetchAcYears() {
      let curYears = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ action: 'fetchYearsFrom' })
      })

      curYears = await curYears.json()
      return curYears
    }

    async function fetchSems() {
      let sems = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ action: 'fetchSems' })
      })
      sems = await sems.json()
      return sems
    }
    
    async function fetchCurrent() {
      let current = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ action: 'fetchCurrent' })
      })
      current = await current.json()
      return current
    }

    async function fetchDeps() {
      let deps = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ action: 'fetchDeps' })
      })
      deps = await deps.json()
      return deps
    }

    async function fetchMonthsBasedOnSemester(acyear, sem) {
      let months = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ acyear, sem, action: 'fetchMonths' })
      })
      months = await months.json()
      return months
    }

    async function fetchFacultiesBasedOnAcYearSemesterDep(acyear, sem, dep) {
      let faculties = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ acyear, sem, dep, action: 'fetchFacs' })
      })
      faculties = await faculties.json()
      return faculties
    }

    async function fetchAcYearsAndSems() {
      let [years, sems, current, deps] = await Promise.all([fetchAcYears(), fetchSems(), fetchCurrent(), fetchDeps()])
      
      let yearsMapped = years.map(year => `<option value="${year.school_year_from}">A.Y. ${year.school_year_from}-${year.school_year_from + 1}</option>`)
      let yearsJoined = yearsMapped.join('')
      $('#ac-year-filter').html(yearsJoined)
      
      let semsMapped = sems.map(sem => `<option value="${sem.sem}">Semester ${sem.sem}</option>`)
      let semsJoined = semsMapped.join('')
      $('#sem-filter').html(semsJoined)

      let depsMapped = deps.map((dep, ind) => `<option value="${dep.dep_id}">${dep.dep_name}</option>`)
      let depsJoined = depsMapped.join('')
      $('#dep-filter').html(depsJoined)

      $('#ac-year-filter').val(current.cur_ay_from)
      $('#sem-filter').val(current.cur_sem)

      let months = await fetchMonthsBasedOnSemester($('#ac-year-filter').val(), $('#sem-filter').val())
      let monthsMapped = months.map(month => `<option value="${month.month}">${month.month}</option>`)
      let monthsJoined = monthsMapped.join('')
      $('#month-filter').html(monthsJoined)

      let faculties = await fetchFacultiesBasedOnAcYearSemesterDep($('#ac-year-filter').val(), $('#sem-filter').val(), $('#dep-filter').val())
      let uniqFacs = []

      faculties.forEach(fac => {
        let check = uniqFacs.some(uniqFac => fac.fac_id == uniqFac?.fac_id)
        check ? '' : uniqFacs.push(fac)
      })

      let uniqFacsMapped = uniqFacs.map(fac => `<option value="${fac.fac_id}">${fac.fac_fname} ${fac.fac_lname}</option>`)
      let uniqFacsJoined = uniqFacsMapped.join('')
      $('#faculty-filter').html(uniqFacsJoined)

    }
    fetchAcYearsAndSems()

    $('#filter-scheds-btn').click(function(e) {
      e.stopPropagation()

      $.ajax({
        url: './assets/action.php',
        method: 'post',
        data: {
          acyear: $('#ac-year-filter').val(),
          sem: $('#sem-filter').val(),
          month: $('#month-filter').val(),
          dep: $('#dep-filter').val(),
          faculty: $('#faculty-filter').val(),
          action: 'filterReports'
        },
        success: function(res) {
          // console.log(res)
        }
      })
    })

    $('#sem-filter').change(function(e) {
      let sem = $(this).val()

      $.ajax({
        url: './assets/action.php',
        method: 'post',
        data: {
          acyear: $('#ac-year-filter').val(),
          sem,
          dep: $('#dep-filter').val(),
          action: 'fetchMonthsFacsBasedOnAcYearSemDep'
        },
        success: function(res) {
          res = JSON.parse(res)
          console.log(res)

          let monthsMapped = res.months.map(month => `<option value="${month.month}">${month.month}</option>`)
          let monthsJoined = monthsMapped.join('')
          $('#month-filter').html(monthsJoined)

          let uniqFacs = []
          res.facs.forEach(fac => {
            let check = uniqFacs.some(uniqFac => fac.fac_id == uniqFac?.fac_id)
            check ? '' : uniqFacs.push(fac)
          })

          let uniqFacsMapped = uniqFacs.map(fac => `<option value="${fac.fac_id}">${fac.fac_fname} ${fac.fac_lname}</option>`)
          let uniqFacsJoined = uniqFacsMapped.join('')
          $('#faculty-filter').html(uniqFacsJoined)
        }
      })
    })
  })
</script>
</body>
</html>