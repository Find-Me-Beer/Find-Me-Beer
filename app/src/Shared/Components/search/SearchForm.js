import React from "react";
import ReactDOM from "react-dom";
import {useSelector} from "react-redux";

export const Search = () => {

	const beer = useSelector((state) => state.beer ? state.beer : null);

	const [searchTerm, setSearchTerm] = React.useState("");
	const [searchResults, setSearchResults] = React.useState([]);
	const handleChange = e => {
		setSearchTerm(e.target.value);
	};
	React.useEffect(() => {
		const results = beer.filter(beer =>
			beer.toLowerCase().includes(searchTerm)
		);
		setSearchResults(results);
	}, [searchTerm]);
	return (
		<div className="Search">
			<input
				type="text"
				placeholder="Search"
				value={searchTerm}
				onChange={handleChange}
			/>
			<ul>
				{searchResults.map(item => (<li>{item}</li>))}
			</ul>
		</div>
	);
};
