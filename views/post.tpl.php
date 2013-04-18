<? include '_header.tpl.php' ?>
<div class='container-wrapper'>
    <? include '_post.tpl.php' ?>

    <? if ($post->slug != 'about'): /* HAMMER TIME */?>
    <footer class='post-footer'>
        <img class='post-avatar' src='/assets/avatar.jpg'>
        <h5>About me</h5>
        <p class='about'>
            Senior web developer, working 
            on advertising and e-commerce products
            at <a href='http://sapo.pt'>SAPO</a>.
            I've a lot of <a href='/projects'>pet projects</a>
            and play a mean paintball game.
            Get in touch at <a href='https://twitter.com/pgcandeias'>@pgcandeias</a>
            or on <a href='http://linkedin.com/in/pedrogilcandeias'>linkedIn</a>.
        </p>
    </footer>
    <? endif ?>
</div>
<? include '_footer.tpl.php' ?>