import './App.css'
import { useNavigate } from 'react-router-dom'
import i from '../../../Images/neom-0SUho_B0nus-unsplash.jpg'

function App() {
	const navigate = useNavigate();
	return (
		<div className='background'>
			<div className='addPost'>
				<h3>Posts</h3>
				<button onClick={() => navigate('/add')} >Add Post</button>
			</div>
			<div className='postList'>
				<div className='post'>
					<div className='postDetails'>
						<h1>Title</h1>
						<h2>Image Text</h2>
						<div>
							<div className='idDiv'>ID : 0</div>
							<button>Edit</button>
							<button>Delete</button>
						</div>
					</div>
					<div className='postImage'>
						<img src={i} />
					</div>
				</div>
			</div>
		</div>
	)
}

export default App
