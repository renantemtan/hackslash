        <div id="map"></div>
        <?php 
            if($_SERVER['REQUEST_URI']=='/views/heatmap.php'){
                include('script.php');
            }else{
                include('defaultscript.php');
            }
        ?>
    </body>
</html>


