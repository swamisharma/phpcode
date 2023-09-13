import React, { useState } from 'react';
import { useDispatch } from 'react-redux';
import { addPost } from '../redux/posts';
import './addPost.css'

function AddPost() {
    const [post, setPost] = useState({
        text: '',
        image: '',
    });
    const dispatch = useDispatch();

    const handleSubmit = (e) => {
        e.preventDefault();
        if (post.text.trim() !== '' && post.text.trim() !== '') {
            dispatch(addPost(post));
        }
    };

    return (
        <div className='background'>
            <h1>
                Add Post
            </h1>
            <form onSubmit={handleSubmit}>
                <label>Title</label>
                <input
                    type="text"
                    placeholder="Add a new post title"
                    value={post.text}
                    onChange={(e) => setPost(prev => {
                        return {...prev, text: e.target.value}
                    })}
                />
                <label>Select Image</label>
                <input 
                    type="file"
                    onChange={(e) => setImage(prev => {
                        return {...prev, image: e.target.value}
                    })}
                />
                <button type="submit">Add</button>
            </form>
        </div>
    );
}

export default AddPost;
