<?php

namespace DcGeneral\Panel;

use DcGeneral\Data\ConfigInterface;
use DcGeneral\DataContainerInterface;
use DcGeneral\Panel\PanelElementInterface;
use DcGeneral\Panel\Interfaces\Panel;
use DcGeneral\InputProviderInterface;

abstract class AbstractElement implements PanelElementInterface
{
	/**
	 * @var Panel
	 */
	protected $objPanel;

	private $objOtherConfig;

	/**
	 * Convenience method to retrieve DataContainer for this Element.
	 *
	 * @return DataContainerInterface
	 */
	public function getDataContainer()
	{
		return $this->getPanel()->getContainer()->getDataContainer();
	}

	/**
	 * Convenience method to retrieve input provider for this Element.
	 *
	 * @return InputProviderInterface
	 */
	public function getInputProvider()
	{
		return $this->getDataContainer()->getInputProvider();
	}

	/**
	 * Return the parenting panel.
	 *
	 * @return Panel
	 */
	public function getPanel()
	{
		return $this->objPanel;
	}

	/**
	 * Return the parenting panel.
	 *
	 * @param Panel $objPanel The panel to use as parent.
	 *
	 * @return PanelElementInterface
	 */
	public function setPanel(Panel $objPanel)
	{
		$this->objPanel = $objPanel;
	}

	/**
	 * Let all other elements initialize and apply themselves to this config.
	 *
	 * @return ConfigInterface
	 */
	protected function getOtherConfig()
	{
		if (!isset($this->objOtherConfig))
		{
			$this->objOtherConfig = $this
				->getDataContainer()
				->getDataProvider()
				->getEmptyConfig();

			$this
				->getPanel()
				->getContainer()
				->initialize($this->objOtherConfig, $this);
		}

		return $this->objOtherConfig;
	}
}
