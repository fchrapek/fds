import { RichText } from "@wordpress/block-editor";

export default function save({ attributes }) {
	const { heading, faqItems } = attributes;

	return (
		<div className="faq-accordion">
			{heading && (
				<RichText.Content
					tagName="h2"
					className="faq-accordion__heading"
					value={heading}
				/>
			)}
			<div className="faq-accordion__items">
				{faqItems.map((item, index) => (
					<details key={item.id || index} className="faq-accordion__item">
						<summary className="faq-accordion__item-header">
							<div className="faq-accordion__item-question-wrapper">
								<span className="faq-accordion__number">{index + 1}.</span>
								<RichText.Content
									tagName="h3"
									className="faq-accordion__question"
									value={item.question}
								/>
							</div>

							<span className="faq-accordion__icon" aria-hidden="true">
								<svg
									width="16"
									height="16"
									viewBox="0 0 16 16"
									fill="none"
									xmlns="http://www.w3.org/2000/svg"
								>
									<path
										d="M4 6L8 10L12 6"
										stroke="currentColor"
										strokeWidth="2"
										strokeLinecap="round"
										strokeLinejoin="round"
									/>
								</svg>
							</span>
						</summary>
						<div className="faq-accordion__item-content">
							<RichText.Content
								tagName="div"
								className="faq-accordion__answer"
								value={item.answer}
							/>
						</div>
					</details>
				))}
			</div>
		</div>
	);
}
