<?php

?>


<div class="container d-flex flex-wrap align-items-center justify-content-center">
    <div class="d-flex align-items-center col-md-6 flex-column">
        <div class="counter"><b id="counter"></b></div>
        <button class="btn btn-primary" id='counter-increaser'>+1</button>
    </div>
</div>


<script type="text/javascript">
    const counter = document.getElementById('counter');
    counter.innerText = <?= $_SESSION['counter'] ?>;
    const btn = document.getElementById('counter-increaser');
    counterIncrease = function () {
        fetch('counter-increment').then(response => {
            console.log(response);
            if (response.status === 200) {
                counter.innerText = Number(document.getElementById('counter').innerText) + 1;
            }
        }).catch((error) => {
            console.log(error)
        });
    };
    btn.addEventListener("click", counterIncrease)
</script>