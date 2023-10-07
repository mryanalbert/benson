<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <div class="d-flex">
        <select name="ac-year-filter" id="ac-year-filter" class="form-select" style="width:170px;"></select>
        <select name="sem-filter" id="sem-filter" class="form-select ms-2" style="width:150px;"></select>
        <select name="dep-filter" id="dep-filter" class="form-select ms-2" style="width:150px;"></select>
        <select name="month-filter" id="month-filter" class="form-select ms-2" style="width:150px;"></select>
        <select name="faculty-filter" id="faculty-filter" class="form-select ms-2" style="width:150px;"></select>

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

      let monthsFaculty = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ 
          yearFrom: $('#ac-year-filter').val(),
          sem: $('#sem-filter').val(),
          dep: $('#dep-filter').val(),
          action: 'fetchAttBasedAcYearAndSem' 
        })
      })
      monthsFaculty = await monthsFaculty.text()
      console.log(monthsFaculty)
    }
    fetchAcYearsAndSems()
  })
</script>
</body>
</html>