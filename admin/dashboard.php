<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <div class="row" style="margin-top: 80px;">
      <div class="col-md-3">
        <div class="card bg-success rounded-0 border-0">
          <div class="card-body mx-auto">
            <i class="bi bi-people text-white" style="font-size: 50px;"></i>
          </div>
          <div class="card-footer text-white text-center" id="count-fac"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-warning rounded-0 border-0">
          <div class="card-body mx-auto">
            <i class="bi bi-buildings text-white" style="font-size: 50px;"></i>
          </div>
          <div class="card-footer text-white text-center" id="count-dep"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-primary rounded-0 border-0">
          <div class="card-body mx-auto">
            <i class="bi bi-door-open text-white" style="font-size: 50px;"></i>
          </div>
          <div class="card-footer text-white text-center" id="count-room"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-danger rounded-0 border-0">
          <div class="card-body mx-auto">
            <i class="bi bi-book text-white" style="font-size: 50px;"></i>
          </div>
          <div class="card-footer text-white text-center" id="count-subject"></div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-top: 25px;">
      <div class="col-md-6">
        <div class="card rounded-0">
          <div class="card-header rounded-0">
            <h6>Faculties by department</h6>
          </div>
          <div class="card-body">
            <canvas id="bar-chart-facs"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card rounded-0">
          <div class="card-header rounded-0 bg-primary">
            <h6 class="text-white">Current A.C. Year & Semester</h6>
          </div>
          <div class="card-body rounded-0">
            <form id="update-cur-form">
              <input type="hidden" name="cur-id" id="cur-id">
              <label class="form-label fs-5">Current Academic Year:</label>
              <select name="cur-ay" id="cur-ay" class="form-select form-select-lg mb-3"></select>

              <label class="form-label fs-5">Current Semester:</label>
              <select name="cur-sem" id="cur-sem" class="form-select form-select-lg mb-4"></select>

              <input type="submit" id="update-cur-btn" value="Change Current A.Y. & Sem" class="btn btn-primary btn-lg">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once './assets/footer.php'; ?>
<script>
  $(document).ready(function() {
    function swal(icon, title, text) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text,
      })
    }

    let changeCurForm = document.getElementById('update-cur-form')
    let updateBtn = document.getElementById('update-cur-btn')
    async function fetchCurYearsOrSems(action) {
      let reqCurYearsOrSems = await fetch(`./assets/action.php`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ action })
      })
      return await reqCurYearsOrSems.json()
    }

    async function fetchFaculties() {
      let res = await fetch('./assets/action.php', {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ action: 'fetchFaculties' })
      })
      let facs = await res.json()
      return facs
    }
    
    async function fetchDeps() {
      let res = await fetch('./assets/action.php', {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ action: 'fetchDeps' })
      })
      let deps = await res.json()
      return deps
    }
    
    async function fetchRooms() {
      let res = await fetch('./assets/action.php', {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ action: 'fetchRooms' })
      })
      let rooms = await res.json()
      return rooms
    }
    
    async function fetchSubjects() {
      let res = await fetch('./assets/action.php', {
        method: 'post',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ action: 'fetchSubjects' })
      })
      let subjects = await res.json()
      return subjects
    }

    async function fetchAll() {
      let [years, sems, current, faculties, deps, rooms, subjects] = await Promise.all([
        fetchCurYearsOrSems('fetchYearsFrom'),
        fetchCurYearsOrSems('fetchSems'),
        fetchCurYearsOrSems('fetchCurrent'),
        fetchFaculties(),
        fetchDeps(),
        fetchRooms(),
        fetchSubjects(),
      ])

      let countFacs = faculties.length
      let countDeps = deps.length
      let countRooms = rooms.length
      let countSubjects = subjects.length
      let facsGroupedByDep = Object.groupBy(faculties, ({ dep_name }) => dep_name)

      let arrDeps = deps.map(dep => dep.dep_name)
      let depsCount = []

      for (key in facsGroupedByDep) {
        depsCount.push(facsGroupedByDep[key].length)
      }

      $('#count-fac').text(`${countFacs} All Faculties`)
      $('#count-dep').text(`${countDeps} Departments`)
      $('#count-room').text(`${countRooms} Rooms`)
      $('#count-subject').text(`${countSubjects} Subjects`)

      years = years.map(year => `<option value="${year.school_year_from}">${year.school_year_from}-${year.school_year_from + 1}</option>`)
      years = years.join('')

      sems = sems.map(sem => `<option value="${sem.sem}">Semester ${sem.sem}</option>`)
      sems = sems.join('')

      document.getElementById('cur-ay').innerHTML = years
      document.getElementById('cur-sem').innerHTML = sems

      document.getElementById('cur-ay').value = current.cur_ay_from
      document.getElementById('cur-sem').value = current.cur_sem
      document.getElementById('cur-id').value = current.id

      // const labels = Utils.months({count: 7});
      const data = {
        labels: arrDeps,
        datasets: [{
          label: 'Faculties Population',
          data: depsCount,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
          ],
          borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
          ],
          borderWidth: 1
        }]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
      };

      const myChart = new Chart(document.querySelector('#bar-chart-facs'), config);
    }
    fetchAll()

    changeCurForm.addEventListener('submit', async e => {
      e.preventDefault()

      updateBtn.setAttribute('value', 'Changing...')
      updateBtn.setAttribute('disabled', true)

      let data = new FormData(changeCurForm)
      data.append('action', 'updateCurrent')
      
      if (changeCurForm.checkValidity()) {
        let res = await fetch(`./assets/action.php`, { method: 'post', body: data })
        res = await res.text()
        
        if (res == '1') {
          swal('success', 'Updated status!')
          updateBtn.setAttribute('value', 'Change Current A.Y. & Sem')
          updateBtn.removeAttribute('disabled')
        }
      }

    })
  })
</script>
</body>
</html>