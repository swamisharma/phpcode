// Action Types
const ADD_POST = 'ADD_POST';
const EDIT_POST = 'EDIT_POST';
const DELETE_POST = 'DELETE_POST';

// Action Creators
export const addPost = (text, image) => ({
    type: ADD_POST,
    payload: {
        text,
        image,
    },
});

export const editPost = (id, text, image) => ({
    type: EDIT_POST,
    payload: { 
        id,
        text,
        image,
    },
});

export const deletePost = (id) => ({
    type: DELETE_POST,
    payload: { id },
})

// Reducer
const initialState = [];
const postsReducer = (state = initialState, action) => {
    switch (action.type) {
        case ADD_POST:
            return [...state, action.payload];
        case EDIT_POST:
            return state.map((post) =>
                post.id === action.payload.id
                ? { ...post, text: action.payload.text, image: action.payload.image }
                : post
            );
        case DELETE_POST:
            return state.filter((post) =>
                post.id !== action.payload.id
            )
        default:
            return state;
    }
};

export default postsReducer;