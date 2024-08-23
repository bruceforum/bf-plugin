/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, QueryControls } from '@wordpress/components';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

const CATEGORIES_LIST_QUERY = {
	per_page: -1,
	context: 'view',
};

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { categories } = attributes;

	const {
		categoriesList,
	} = useSelect(
		(select) => {
			const { getEntityRecords } = select(coreStore);

			return {
				categoriesList: getEntityRecords(
					'taxonomy',
					'category',
					CATEGORIES_LIST_QUERY
				),
			};
		},
		[
			categories,
		]
	);
	const categorySuggestions =
		categoriesList?.reduce(
			(accumulator, category) => ({
				...accumulator,
				[category.name]: category,
			}),
			{}
		) ?? {};
	const selectCategories = (tokens) => {
		const hasNoSuggestion = tokens.some(
			(token) =>
				typeof token === 'string' && !categorySuggestions[token]
		);
		if (hasNoSuggestion) {
			return;
		}
		// Categories that are already will be objects, while new additions will be strings (the name).
		// allCategories nomalizes the array so that they are all objects.
		const allCategories = tokens.map((token) => {
			return typeof token === 'string'
				? categorySuggestions[token]
				: token;
		});
		// We do nothing if the category is not selected
		// from suggestions.
		if (allCategories.includes(null)) {
			return false;
		}
		setAttributes({ categories: allCategories });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Sorting and filtering')}>
					<QueryControls
						categorySuggestions={categorySuggestions}
						onCategoryChange={selectCategories}
						selectedCategories={categories}
					/>
				</PanelBody>
			</InspectorControls>
			<p {...useBlockProps()}></p>
		</>
	);
}