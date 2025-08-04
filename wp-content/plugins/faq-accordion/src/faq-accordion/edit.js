import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import { useId } from "@wordpress/element";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
	const { heading, faqItems } = attributes;
	const baseId = useId();

	const blockProps = useBlockProps({
		className: "faq-accordion-editor",
	});

	const addFAQItem = () => {
		const newItems = [
			...faqItems,
			{
				id: `${baseId}-${faqItems.length}`,
				question: "",
				answer: "",
			},
		];
		setAttributes({ faqItems: newItems });
	};

	const updateFAQItem = (index, field, value) => {
		const newItems = [...faqItems];
		newItems[index] = { ...newItems[index], [field]: value };
		setAttributes({ faqItems: newItems });
	};

	const removeFAQItem = (index) => {
		const newItems = faqItems.filter((_, i) => i !== index);
		setAttributes({ faqItems: newItems });
	};

	return (
		<div {...blockProps}>
			<div className="faq-accordion">
				<RichText
					tagName="h2"
					className="faq-accordion__heading"
					placeholder={__("Enter FAQ heading...", "faq-accordion")}
					value={heading}
					onChange={(heading) => setAttributes({ heading })}
					allowedFormats={["core/bold", "core/italic"]}
				/>
				<div className="faq-accordion__items">
					{faqItems.map((item, index) => {
						if (!item.id) {
							item.id = `${baseId}-${index}`;
						}
						return (
							<div key={item.id} className="faq-accordion__item">
								<div className="faq-accordion__item-header">
									<div className="faq-accordion__item-question-wrapper">
										<span className="faq-accordion__number">{index + 1}.</span>
										<RichText
											tagName="h3"
											className="faq-accordion__question"
											placeholder={__("Enter question...", "faq-accordion")}
											value={item.question}
											onChange={(value) =>
												updateFAQItem(index, "question", value)
											}
											allowedFormats={["core/bold", "core/italic"]}
											identifier={`question-${item.id}`}
										/>
									</div>
									<Button
										isDestructive
										size="small"
										onClick={() => removeFAQItem(index)}
									>
										{__("Remove", "faq-accordion")}
									</Button>
								</div>
								<div className="faq-accordion__item-content">
									<RichText
										tagName="div"
										className="faq-accordion__answer"
										placeholder={__("Enter answer...", "faq-accordion")}
										value={item.answer}
										onChange={(value) => updateFAQItem(index, "answer", value)}
										allowedFormats={["core/bold", "core/italic", "core/link"]}
										identifier={`answer-${item.id}`}
									/>
								</div>
							</div>
						);
					})}
				</div>
				<Button variant="primary" onClick={addFAQItem}>
					{__("Add FAQ Item", "faq-accordion")}
				</Button>
			</div>
		</div>
	);
}
