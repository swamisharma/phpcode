import React from 'react';
import { useDispatch } from 'react-redux';
import { editPost } from '../redux/todos';

export default function PostItem({ id, text, image }) {
    const dispatch = useDispatch();

    const handleEdit = () => {
        dispatch(editPost(id, text, image));
    };

    const handleDelete = () => {
        dispatch(deletePost(id));
    }

    return (
        <div>
        <input
            type="checkbox"
            checked={completed}
            onChange={handleToggle}
        />
        <span>{text}</span>
        </div>
    );
}