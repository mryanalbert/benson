<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <form id="update-cur-form">
      <input type="hidden" name="cur-id" id="cur-id">
      <label class="form-label">Current Academic Year:</label>
      <select name="cur-ay" id="cur-ay" class="form-select mb-3"></select>

      <label class="form-label">Current Semester:</label>
      <select name="cur-sem" id="cur-sem" class="form-select mb-4"></select>

      <input type="submit" id="update-cur-btn" value="Change Current A.Y. & Sem" class="btn btn-primary">
    </form>
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

    async function fetchAll() {
      let [years, sems, current] = await Promise.all([
        fetchCurYearsOrSems('fetchYearsFrom'),
        fetchCurYearsOrSems('fetchSems'),
        fetchCurYearsOrSems('fetchCurrent')
      ])
      console.log(years)
      console.log(sems)
      console.log(current)

      years = years.map(year => `<option value="${year.school_year_from}">${year.school_year_from}-${year.school_year_from + 1}</option>`)
      years = years.join('')

      sems = sems.map(sem => `<option value="${sem.sem}">Semester ${sem.sem}</option>`)
      sems = sems.join('')

      document.getElementById('cur-ay').innerHTML = years
      document.getElementById('cur-sem').innerHTML = sems

      document.getElementById('cur-ay').value = current.cur_ay_from
      document.getElementById('cur-sem').value = current.cur_sem
      document.getElementById('cur-id').value = current.id
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