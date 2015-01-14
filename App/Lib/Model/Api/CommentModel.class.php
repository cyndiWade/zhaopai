<?php

//评论
class CommentModel extends ApiBaseModel {

	public function add_comment($id,$article_id,$comment_content)
	{
		$count = $this->where(array('article_id'=>$article_id,'user_id'=>$id))->count();
		if($count==0)
		{
			$new_add = array(
				'article_id' => $article_id,
				'user_id' => $id,
				'content' => $comment_content,
				'create_time' => time()
			);
			$bool = $this->add($new_add);
			return $bool ? true : false;
		}else{
			return false;
		}
	}

	public function select_info($p,$index,$article_id)
	{
		$first = $p =='' ? 0 : $p;
		$long = $index == '' ? 10 : $index;
		$new_list = array();
		$new_list['count'] = $this->where(array('article_id'=>$article_id))->count();
		$list = $this->where(array('c.article_id'=>$article_id))
		->table('app_comment as c')->join('app_users as u on u.id = c.user_id')->limit($first,$long)
		->field('c.id,c.content,c.create_time,u.id as user_id,u.nickname,u.head_img')->select();
		foreach($list as $key=>$value)
		{
			$value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
			$new_list['commemt_info'][$key] = $value;
		}
		return $new_list;
	}
}