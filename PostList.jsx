import React from 'react';
import PostItem from './PostItem';
import { useSelector } from 'react-redux';

export default function PostList() {
    const posts = useSelector((state) => state.posts);

    return (
        <div>
            {posts.map((post) => (
                <PostItem key={post.id} {...post} />
            ))}
        </div>
    );
}