import ReactDOM from 'react-dom';
import classNames from "classnames";
import React, { Component } from 'react';

class Ingredients extends Component {

    constructor(props) {
        super(props);

        this.state = {
            ingredients: [],
            rawIngredients: [],
            rawFilteredIngredients: []
        };
    }

    // Handle initial component load.
    componentDidMount() {
        fetch('/api/ingredients')
        .then(results => {
            return results.json();
        }).then(data => {
            this.setState({ rawIngredients: data.ingredients });
            this.setIngredientItems(data.ingredients);
        });
    }

    // Handle when component updates.
    componentDidUpdate(previousProps) {
        // If the selected ingredients has changed, re-render ingredients.
        if (previousProps.selectedIngredients !== this.props.selectedIngredients) {
            if (this.state.rawFilteredIngredients.length > 0) {
                this.setIngredientItems(this.state.rawFilteredIngredients);
            } else {
                this.setIngredientItems(this.state.rawIngredients);
            }
        }
    }

    // Set ingredient items.
    setIngredientItems(ingredientItems) {
        let ingredients = ingredientItems.map((ingredient) => {
            let ingredientItemClasses = classNames (
                'mb-2',
                'py-2',
                'px-4',
                'border-2',
                'rounded-full',
                'cursor-pointer',
                'font-semi-bold',
                'text-xs',
                {
                    'text-white bg-peach': this.props.selectedIngredients.some(selectedIngredient => (
                        selectedIngredient === ingredient.id
                    )),
                    'border-peach text-peach': !this.props.selectedIngredients.some(selectedIngredient => (
                        selectedIngredient === ingredient.id
                    ))
                }
            );

            return (
                <div key={ ingredient.id } onClick={ this.props.selectIngredient.bind(this, ingredient.id) } className={ingredientItemClasses}>
                    <p className="font-bold">{ ingredient.name.toLowerCase() }</p>
                </div>
            );
        });

        this.setState({ ingredients: ingredients });
    }

    // Handle filtering ingredients.
    filterIngredients(event) {
        let filteredIngredients = this.state.rawIngredients;
        filteredIngredients = filteredIngredients.filter((ingredient) => {
            return ingredient.name.toLowerCase().search(event.target.value.toLowerCase()) !== -1;
        });

        this.setState({ rawFilteredIngredients: filteredIngredients });
        this.setIngredientItems(filteredIngredients);
    }

    // Render
    render() {
        return (
            <div>
                <div className="flex justify-between items-center">
                    <h1 className="text-xl font-bold">Ingredients</h1>
                    <div>
                        <span className="text-peach cursor-pointer" onClick={ this.props.clearSelectedIngredients.bind(this) }>Clear</span>
                    </div>
                </div>

                <input type="text"
                       name="search"
                       autoComplete="off"
                       onChange={ this.filterIngredients.bind(this) }
                       placeholder="Search for ingredient..."
                       className="focus:outline-none mt-5 mb-5 appearance-none w-full py-1 px-2 mb-1 border-2 border-grey-background bg-grey-background font-semi-bold py-2 px-4 rounded-full"
                />
                <div className="overflow-scroll h-screen pb-64">
                    { this.state.ingredients }
                </div>
            </div>
        );
    }

}

export default Ingredients;

if (document.getElementById('ingredients')) {
    ReactDOM.render(<Ingredients />, document.getElementById('ingredients'));
}