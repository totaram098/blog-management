function confrim_delete(obj){
	var post_id = obj.getAttribute("post_id");
	if (confirm("Are you sure..? You want to delete this post")) {
		window.location="../manage_posts.php?action=delete&post_id="+post_id;
	}
}

function confrim_edit(obj){
	var post_id = obj.getAttribute("post_id");
	if (confirm("Are you sure..? You want to Edit this post")) {
		window.location="dashboard.php?action=edit&post_id="+post_id;
	}
}