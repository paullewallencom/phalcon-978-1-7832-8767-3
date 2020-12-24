ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_posts1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`);
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
ALTER TABLE `post_tags`
  ADD CONSTRAINT `fk_post_tags_tags1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `fk_post_tags_posts1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`);