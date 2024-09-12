let ticking = false;

function updateProgressBar() {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  const windowHeight = window.innerHeight;
  const documentHeight = Math.max(
    document.body.scrollHeight, 
    document.body.offsetHeight, 
    document.documentElement.clientHeight, 
    document.documentElement.scrollHeight, 
    document.documentElement.offsetHeight
  );

  const scrollPercentage = (scrollTop / (documentHeight - windowHeight)) * 100;
  const progressBar = document.getElementById('progress-bar');
  progressBar.style.width = scrollPercentage + '%';

  ticking = false;
}

function requestTick() {
  if (!ticking) {
    requestAnimationFrame(updateProgressBar);
    ticking = true;
  }
}

window.addEventListener('scroll', requestTick);
