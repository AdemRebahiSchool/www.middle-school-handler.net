setTimeout(function () {
    var loadingOverlay = document.querySelector('.loading-overlay');
    loadingOverlay.style.display = 'none';
}, 700);

document.getElementById('accessHeading').addEventListener('click', function() {
    // Toggle the visibility of the sections
    document.querySelectorAll('.Management, .Teacher, .Staff2, .Staff, .Parent, .Student').forEach(function(section) {
        section.style.display = (section.style.display === 'none') ? 'block' : 'none';
    });
});