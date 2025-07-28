<!-- 
  <div class="col-md-6">
            <?php print_r($settings); ?>
           <form method="post" enctype="multipart/form-data">
            <input type="text" name="library_name" value="<?= $settings['library_name'] ?>" required>
            <input type="number" name="download_limit" value="<?= $settings['download_limit'] ?>" required>
            
            <label>Library Logo</label>
            <input type="file" name="logo" accept="image/*">
            <?php if (!empty($settings['logo'])): ?>
                <img src="../uploads/<?= $settings['logo'] ?>" style="max-width: 100px;" class="mt-2">
            <?php endif; ?>
            </div> -->