import { createStore, combineReducers } from 'redux';
import postsReducer from './posts';

const rootReducer = combineReducers({
    posts: postsReducer,
});

const store = createStore(rootReducer);

export default store;
