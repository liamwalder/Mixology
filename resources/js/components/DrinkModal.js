import classNames from "classnames";
import React, { Component } from 'react';

class DrinkModal extends Component {

    // Constructor
    constructor(props) {
        super(props);

        console.log(this.props.drink);
    }


    // Render
    render() {

        // If we don't have a drink, don't render the drink.
        if (!this.props.drink.id) {
            return (
                <div></div>
            )
        }

        // Classes to assign to the modal
        let modalClass = classNames (
            'modal',
            'flex',
            'fixed',
            'top-0',
            'w-full',
            'h-full',
            'left-0',
            'items-center',
            'justify-center',
            {
                'opacity-0': this.props.drink.length === 0
            }
        );

        return (
            <div className={ modalClass }>
                <div className="modal-overlay absolute w-full h-full bg-grey-background opacity-50"></div>

                <div className="modal-container bg-white w-11/12 lg:w-10/12 xl:w-7/12 mx-auto rounded shadow-lg z-50 overflow-y-auto">

                    <div className="modal-close absolute top-0 right-0 bg-peach rounded-full flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                        <span className="text-lg p-5 cursor-pointer" onClick={ this.props.selectDrink.bind(this, []) }>
                            <svg className="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </span>
                    </div>

                    <div className="modal-content text-left p-6">

                        <div className="bg-white rounded-lg flex-grow flex-grow-0">
                            <div className="flex flex-row mb-2">
                                <img className="rounded-lg w-3/12 mr-4 h-full" src={ this.props.drink.thumbnail.url } alt={ this.props.drink.name.toLowerCase() } />
                                <div className="flex flex-col w-9/12">
                                    <div className="font-bold text-xl w-8/12 mb-4">{ this.props.drink.name.toLowerCase() }</div>
                                    <div className="hidden md:block">
                                        <div className="flex flex-row mb-4">
                                            <span className="text-sm font-semibold mr-2 text-orange-text bg-orange-background py-2 px-4 rounded-lg">{ this.props.drink.category.name.toLowerCase() }</span>
                                            <span className="text-sm font-semibold mr-2 text-lightorange-text bg-lightorange-background py-2 px-4 rounded-lg">{ this.props.drink.alcoholicFilter.name.toLowerCase() }</span>
                                            <span className="text-sm font-semibold text-yellow-text bg-yellow-background py-2 px-4 rounded-lg">{ this.props.drink.glass.name.toLowerCase() }</span>
                                        </div>
                                        <p className="text-md font-semibold">{ this.props.drink.instructions }</p>
                                    </div>
                                </div>
                            </div>
                            <div className="sm:block md:hidden">
                                <div className="flex flex-col mb-2">
                                    <span className="w-full mb-1 text-sm font-semibold mr-2 text-orange-text bg-orange-background py-2 px-4 rounded-lg">{ this.props.drink.category.name.toLowerCase() }</span>
                                    <span className="w-full mb-1 text-sm font-semibold mr-2 text-lightorange-text bg-lightorange-background py-2 px-4 rounded-lg">{ this.props.drink.alcoholicFilter.name.toLowerCase() }</span>
                                    <span className="w-full text-sm font-semibold text-yellow-text bg-yellow-background py-2 px-4 rounded-lg">{ this.props.drink.glass.name.toLowerCase() }</span>
                                </div>
                                <p className="text-md font-semibold">{ this.props.drink.instructions }</p>
                            </div>
                        </div>

                        <div className="px-2 py-2 w-full bg-white mr-4 items-center border-t-2 border-grey-background pt-4 mt-5">
                            <div className="flex flex-row flex-wrap mb-2">
                                {this.props.drink.ingredients.data.map((drinkIngredient, index) => {
                                    // Class to assign to ingredient item.
                                    let ingredientItemClasses = classNames (
                                        'text-sm',
                                        'flex',
                                        'flex-col',
                                        'font-bold',
                                        'w-6/12',
                                        'mb-1',
                                        {
                                            'text-grey-background': !this.props.selectedIngredients.some(selectedIngredient => (
                                                selectedIngredient === drinkIngredient.ingredient.id
                                            )),
                                            'text-peach': this.props.selectedIngredients.some(selectedIngredient => (
                                                selectedIngredient === drinkIngredient.ingredient.id
                                            ))
                                        }
                                    );

                                    return <div key={ drinkIngredient.id } className={ingredientItemClasses}>
                                            <span>{ drinkIngredient.measure ? drinkIngredient.measure + ' / ' : '' }{ drinkIngredient.ingredient.name.toLowerCase() }</span>
                                        </div>
                                })}
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        );

    }

}

export default DrinkModal;