<div class="block">
    <h2>File Manager</h2>
<?php
if( count($this->messages) > 0 )
{
	foreach( $this->messages as $message )
	{
		print '<p class="simple-message simple-message-'.$message->getType().'">'.$message->getMessage().'</p>';
	}
}
else
{
?>
    <p>Below is a complete list of all uploaded files.</p>
    <form id="module-browse" class="clear-fix" action="<?php print $this->uri(); ?>" enctype="multipart/form-data" method="post">
    <table class="table-data" cellspacing="0" cellpadding="0" border="0">
        <thead>
            <tr>
                <th class="first center" style="width:5%;"><input type="checkbox" value="0" /></th>
                <th>Filename</th>
                <th class="last">Options</th>
            </tr>
        </thead>
        <tbody>
<?php
	foreach( $this->files as $file )
	{
?>
			<tr>
            	<td class="first center"><input name="file-select[]" type="checkbox" value="<?php print $file->getFilename(); ?>" /></td>
                <td><?php print $file->getFile(); ?></td>
                <td class="last options"><a href="<?php print $this->uri(array('file-select' => $file->getFilename())); ?>" class="mini-button mini-button-delete" title="Are you sure you want to delete this file?" rel="record delete">Delete</a></td>
            </tr>
<?php
	}
?>
        </tbody>
    </table>
<?php
	print '<div class="paginator clear-fix">'.$this->paginator.'</div>';
?>
    <div class="clear-fix form-buttons form-field-submit field-delete">

        <div class="input-left">
            <div class="input-right">
                <input rel="record delete" title="Are you sure you want to delete this selected file(s)" value="Delete Selected" type="submit" class="input-submit">
            </div>
        </div>
    </div>

    <!--<div class="clear-fix form-buttons form-field-link">
        <div class="input-left">
            <div class="input-right">
                <a href="<?php print $this->uri(array('file-select' => $file->getFilename())); ?>" class="input-submit">Optimize Images</a>
            </div>
        </div>
    </div>-->
    </form>
<?php
}
?>
</div>