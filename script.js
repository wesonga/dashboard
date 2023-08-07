const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

const indexLink = document.querySelector('.side-menu.top li:nth-child(1) a'); // Assuming Users link is the second item in the list

indexLink.addEventListener('click', function (e) {
    e.preventDefault();

    // Redirect to users.php
    window.location.href = 'index.php';
});


const usersLink = document.querySelector('.side-menu.top li:nth-child(2) a'); // Assuming Users link is the second item in the list

usersLink.addEventListener('click', function (e) {
    e.preventDefault();

    // Redirect to users.php
    window.location.href = 'users.php';
});

const diseaseLink = document.querySelector('.side-menu.top li:nth-child(3) a'); // Assuming Users link is the second item in the list

diseaseLink.addEventListener('click', function (e) {
    e.preventDefault();

    // Redirect to users.php
    window.location.href = 'disease.php';
});

const sosLink = document.querySelector('.side-menu.top li:nth-child(4) a'); // Assuming Users link is the second item in the list

sosLink.addEventListener('click', function (e) {
    e.preventDefault();

    // Redirect to users.php
    window.location.href = 'sos.php';
});

const caseLink = document.querySelector('.side-menu.top li:nth-child(5) a'); // Assuming Users link is the second item in the list

caseLink.addEventListener('click', function (e) {
    e.preventDefault();

    // Redirect to users.php
    window.location.href = 'cases.php';
});





const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})