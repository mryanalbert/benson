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

    <div class="row">
      <div class="col-12">
        <div class="card rounded-0 shadow-sm">
          <div class="card-header bg-primary rounded-0">
            <span class="fs-5 text-white">Attendance Record</span>
          </div>
          <div class="card-body rounded-0">
            <div class="table-responsive" id="data-wrapper">
              <div class="d-flex align-items-center justify-content-center">
                <div class="spinner-border text-secondary" role="status"></div>
                <h2 class="text-secondary ms-2">Loading...</h2>
              </div>
            </div>
          </div>
        </div>
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

      fetchAtt()
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
          res = JSON.parse(res)
          console.log(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="report-table">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Time-in</th>
                    <th>Time-out</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(att => {
              output += `
                <tr>
                  <td>${att.day}</td>
                  <td>${att.date}</td>
                  <td>${att.at_in}</td>
                  <td>${att.at_out}</td>
                  <td>
                    <a href="#" title="Details" class="view-report-modal text-decoration-none" id="view-report-${att.at_id}" data-bs-toggle="modal" data-bs-target="#view-report-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-report-modal text-decoration-none" id="edit-report-${att.at_id}" data-bs-toggle="modal" data-bs-target="#edit-report-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-report-modal" id="del-report-${att.at_id}">
                      <i class="bi bi-trash-fill fs-5 text-danger"></i>
                    </a>
                  </td>
                </tr>
              `
            })

            output += `
                </tbody>
              </table
            `
            $("#data-wrapper").html(output)

            // Setup - add a text input to each footer cell
            // $('#report-table thead td').each(function() {
            //   let title = $(this).text()
            //   $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control w-100" />`)
            // })

            // DataTable
            let table = $('#report-table').DataTable({
              // initComplete: function() {
              //   // Apply the search
              //   this.api().columns().every(function() {
              //     let that = this
                  
              //     $('input', this.header()).on('keyup change clear', function() {
              //       if (that.search() !== this.value) {
              //         that
              //           .search(this.value)
              //           .draw()
              //       }
              //     })
              //   })
              // },
              buttons:['copy', 'csv', 'excel', 'pdf', 'print']
            })
            table.buttons().container().appendTo('#data-wrapper .col-md-6:eq(0)')

          } else {
            $('#data-wrapper').html('<h4 class="text-center text-secondary fst-italic">No records.</h4>')
          }
          // let tableBtns = $('#report-table').DataTable({buttons:['copy', 'csv', 'excel', 'pdf', 'print']});
          // tableBtns.buttons().container().appendTo('#data-wrapper .col-md-6:eq(0)')
        }
      })
    })

    function fetchAtt() {
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
          res = JSON.parse(res)
          console.log(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="report-table">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Time-in</th>
                    <th>Time-out</th>
                    <th>Actions</th>
                  </tr>
                  <tr>
                    <td>Day</td>
                    <td>Date</td>
                    <td>Time-in</td>
                    <td>Time-out</td>
                    <td class="d-none">Actions</td>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(att => {
              output += `
                <tr>
                  <td>${att.day}</td>
                  <td>${att.date}</td>
                  <td>${att.at_in}</td>
                  <td>${att.at_out}</td>
                  <td>
                    <a href="#" title="Details" class="view-report-modal text-decoration-none" id="view-report-${att.at_id}" data-bs-toggle="modal" data-bs-target="#view-report-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-report-modal text-decoration-none" id="edit-report-${att.at_id}" data-bs-toggle="modal" data-bs-target="#edit-report-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-report-modal" id="del-report-${att.at_id}">
                      <i class="bi bi-trash-fill fs-5 text-danger"></i>
                    </a>
                  </td>
                </tr>
              `
            })

            output += `
                </tbody>
              </table
            `
            $("#data-wrapper").html(output)

            // Setup - add a text input to each footer cell
            $('#report-table thead td').each(function() {
              let title = $(this).text()
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control w-100" />`)
            })

            // DataTable
            let table = $('#report-table').DataTable({
              initComplete: function() {
                // Apply the search
                this.api().columns().every(function() {
                  let that = this
                  
                  $('input', this.header()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                      that
                        .search(this.value)
                        .draw()
                    }
                  })
                })
              }
            })
          } else {
            $('#data-wrapper').html('<h4 class="text-center text-secondary fst-italic">No records.</h4>')
          }
        }
      })
    }

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

    $('#dep-filter').change(function(e) {
      e.stopPropagation()

      let dep = $(this).val()

      $.ajax({
        url: './assets/action.php',
        method: 'post',
        data: {
          acyear: $('#ac-year-filter').val(),
          sem: $('#sem-filter').val(),
          dep,
          action: 'fetchFacsBasedAcYearSemDep'
        },
        success: function(res) {
          res = JSON.parse(res)

          let uniqFacs = []
          res.forEach(fac => {
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